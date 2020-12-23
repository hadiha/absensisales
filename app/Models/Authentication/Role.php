<?php 
namespace App\Models\Authentication;

use Zizaco\Entrust\EntrustRole;
use App\Models\Traits\Utilities;

class Role extends EntrustRole
{
    use Utilities;
    protected $fillable = [
      'display_name', 'name', 'description'
    ];
	
}