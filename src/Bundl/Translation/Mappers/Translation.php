<?php
/**
 * @author  brooke.bryan
 */

namespace Bundl\Translation\Mappers;

use Cubex\Mapper\Database\RecordMapper;

class Translation extends RecordMapper
{
  protected $_dbServiceName = 'bundl.translations';
  protected $_dbTableName = 'translations';

  public $original_id;
  public $language;
  public $translated;
  public $approved;
  public $approved_on;
  public $approved_by;

  public function original()
  {
    return $this->belongsTo(new Original());
  }

  public function approver()
  {
    return $this->belongsTo(new Approver());
  }
}
