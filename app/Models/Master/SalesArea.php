<?php 
namespace App\Models\Master;

use App\Models\Authentication\User;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Illuminate\Database\Eloquent\Model;

class SalesArea extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'ref_sales_area';
    protected $fillable = [
      'user_id', 'area_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
  
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}