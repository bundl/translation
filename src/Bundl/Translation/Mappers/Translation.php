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

  public $originalId;
  public $language;
  public $translated;
  public $approved;
  public $approvedOn;
  public $approvedBy;

  public function original()
  {
    return $this->belongsTo(new Original());
  }

  public function approver()
  {
    return $this->belongsTo(new Approver());
  }
}
