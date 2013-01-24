<?php
/**
 * @author  brooke.bryan
 */

namespace Bundl\Translation\Mappers;

use Cubex\Mapper\Database\RecordMapper;

class Original extends RecordMapper
{
  protected $_dbServiceName = 'bundl.translations';
  protected $_dbTableName = 'originals';

  public $lookup;

  public function translations()
  {
    return $this->hasMany(new Translation());
  }
}
