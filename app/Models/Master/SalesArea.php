<?php 
namespace App\Models\Master;

use App\Models\Authentication\User;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SalesArea extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'ref_sales_area';
    protected $fillable = [
      'client_id','user_id', 'area_id','start_date', 'end_date', 'koordinator_id'
    ];

    protected $dates = [
      'start_date', 'end_date'
    ];

    // Accessors & Mutators
    public function setStartDateAttribute($value)
    {
        if ($this->preventAttrSet) {
            return $this->attributes['start_date'] = $value;
        } else {
            return $this->attributes['start_date'] = !is_null($value) ? Carbon::createFromFormat('d/m/Y', $value) : null;
        }
    }

    public function setEndDateAttribute($value)
    {
        if ($this->preventAttrSet) {
            return $this->attributes['end_date'] = $value;
        } else {
            return $this->attributes['end_date'] = !is_null($value) ? Carbon::createFromFormat('d/m/Y', $value) : null;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
  
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function koordinator()
    {
        return $this->belongsTo(User::class, 'koordinator_id');
    }
}