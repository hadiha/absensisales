<?php

namespace App\Models\Authentication;

use App\Models\Main\Absensi;
use App\Models\Master\Area;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

// entrust
use Zizaco\Entrust\Traits\EntrustUserTrait;

// Models
use App\Models\Master\Karyawan;
use App\Models\Master\SalesArea;
use App\Models\Project\Project;
use App\Models\Project\Task;
use App\Models\Traits\Utilities;

class User extends Authenticatable implements JWTSubject
{
    use Utilities;
    use Notifiable;
    use EntrustUserTrait;

    public $table = 'sys_users';
    public $remember_token = false;

    protected $dates = ['last_login'];
    protected $fillable = [
      'username','name','foto','phone', 'password', 'email', 'deleted_at', 'last_login'
    ];

    protected $appends = [
        'area'
    ];

    // Mutator & Accessor
    public function getAreaAttribute($value)
    {
        // return 0;
        $sales = SalesArea::where('user_id', $this->id)->first();

        return $sales ? $sales->area['name'] : '-';
    }


    /* Relation */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'pegawai_id');
    }

    public function absen()
    {
        return $this->hasOne(Absensi::class, 'pegawai_id');
    }
    
    public function salesarea()
    {
        return $this->hasOne(SalesArea::class, 'area_id');
    }
    /* End Relation */

    /* Mutator */
    
    /* End Mutator */

    /* Custom Function */
    public function hadir()
    {
        return $this->absensi->where('status', 'hadir')->count();
    }

    public function izin()
    {
        return $this->absensi->where('status', 'izin')->count();
    }

    public function sakit()
    {
        return $this->absensi->where('status', 'sakit')->count();
    }

    public function cuti()
    {
        return $this->absensi->where('status', 'cuti')->count();
    }

    /* End Custom Function */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
