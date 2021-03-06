<?php
/**
 * @author  brooke.bryan
 */

namespace Bundl\Translation;

use Bundl\Translation\Mappers\Original;
use Bundl\Translation\Mappers\Translation;
use Cubex\Foundation\Config\ConfigTrait;
use Cubex\I18n\Translator\ITranslator;
use Cubex\Mapper\Database\RecordCollection;

class Translator implements ITranslator
{
  use ConfigTrait;

  /**
   * @var ITranslator
   */
  protected $_fallback;

  public function fallbackTranslator(ITranslator $fall)
  {
    $this->_fallback = $fall;
  }

  public function translate($text, $sourceLanguage, $targetLanguage)
  {
    $originals = new RecordCollection(new Original(), ['id']);
    $original  = $originals->loadOneWhere("%C = %s", "lookup", $text);

    if($original === null || !$original->exists())
    {
      $original         = new Original();
      $original->lookup = $text;
      $original->saveChanges();
    }

    $translation = Translation::loadWhere(
      "%C = %d AND %C = %s",
      "original_id",
      $original->id(),
      "language",
      $targetLanguage
    );

    if($translation !== null && $translation instanceof Translation)
    {
      if($translation->exists())
      {
        $translated = $translation->translated;
        return $translated;
      }
    }

    if($this->_fallback === null)
    {
      $this->_fallback = $this->_getTranslator();
    }

    $translated = $this->_fallback->translate(
      $text,
      $sourceLanguage,
      $targetLanguage
    );

    if($translated !== $text)
    {
      $translation             = new Translation();
      $translation->originalId = $original->id();
      $translation->language   = $targetLanguage;
      $translation->translated = $translated;
      $translation->saveChanges();
    }

    return $translated;
  }

  protected function _getTranslator()
  {
    $conf    = $this->config('bundl\translation');
    $default = 'Cubex\I18n\Translator\Notranslator';
    if($conf !== null)
    {
      $translator = $conf->getStr("translator", $default);
      if(!class_exists($translator))
      {
        $translator = $default;
      }
    }
    else
    {
      $translator = $default;
    }

    $t = new $translator();
    if($t instanceof ITranslator)
    {
      $t->configure($this->_configuration);
    }

    return $t;
  }
}
