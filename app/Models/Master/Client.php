<?php 
namespace App\Models\Master;

use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'ref_client';
    protected $fillable = [
      'code', 'name', 'fileurl', 'filename'
    ];
	
}