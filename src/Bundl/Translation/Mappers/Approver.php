<?php
/**
 * @author  brooke.bryan
 */

namespace Bundl\Translation\Mappers;

use Cubex\Mapper\Database\RecordMapper;

class Approver extends RecordMapper
{
  protected $_dbServiceName = 'bundl.translations';
  protected $_dbTableName = 'approvers';

  public $name;
  public $email;

  public function translations()
  {
    return $this->hasMany(new Translation());
  }
}
