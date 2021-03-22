<?php

namespace App\Models\Authentication;

use App\Models\Main\Absensi;
use App\Models\Master\Area;
use App\Models\Master\Client;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
// use hisorange\BrowserDetect\Facade as Browser;

// entrust
use Zizaco\Entrust\Traits\EntrustUserTrait;

// Models
use App\Models\Master\SalesArea;
use App\Models\Traits\Utilities;
// use App\Modelss\Authentication\AuditTrail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class User extends Authenticatable implements JWTSubject
{
    use Utilities;
    use Notifiable;
    use EntrustUserTrait;

    public $table = 'sys_users';
    public $remember_token = false;

    protected $dates = ['last_login'];
    protected $fillable = [
      'username','name','foto','phone', 'password', 'email', 'deleted_at', 'last_login', 'client_id'
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
        return $this->hasMany(Absensi::class, 'pegawai_id')->orderBy('created_at', 'ASC');
    }

    public function absensiSakit()
    {
        return $this->hasMany(Absensi::class, 'pegawai_id')->where('status', 'sakit');
    }

    public function absensiHadir()
    {
        return $this->hasMany(Absensi::class, 'pegawai_id')->where('status', 'hadir');
    }

    public function absensiIzin()
    {
        return $this->hasMany(Absensi::class, 'pegawai_id')->where('status', 'izin');
    }

    public function audits()
    {
        return $this->hasMany(AuditTrail::class, 'user_id')
                    ->orderBy('created_at', 'desc');;
    }

    public function absen()
    {
        return $this->hasOne(Absensi::class, 'pegawai_id');
    }
    
    public function salesarea()
    {
        return $this->hasOne(SalesArea::class, 'area_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'client_id');
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

    public function alfa($date)
    {
        $frm = Carbon::parse($date);
        $now = $frm->isPast() ? $frm->endOfMonth() : Carbon::now();
        $str = $now->copy()->startOfMonth();
        $dif = $str->diffInDays($now);

        return $dif - ($this->hadir() + $this->sakit() + $this->izin() + $this->cuti());
    }

    public function getAbsensiAlfaCountAttribute()
    {
        $date = request()->has('month') && request()->has('year') ? request()->year.'-'.request()->month : Carbon::now()->format('Y-m');
        return $this->alfa($date);
    }

    public function showfotopath()
    {
        if($this->foto)
        {
            return asset('storage/'.$this->foto);
        }

        return asset('img/no-images.png');
    }

    public function picUpload($file)
    {
        if($file)
        {
            if($this->foto != NULL)
            {
                if(file_exists(storage_path().'/app/public/'.$this->foto))
                {
                    unlink(storage_path().'/app/public/'.$this->foto);
                }
            }

            $url = $file->storeAs('profile', md5($file->getClientOriginalName().Carbon::now()->format('Ymdhis')).'.'.$file->getClientOriginalExtension(), 'public');

            $this->foto = $url;
            $this->save();

            return $url;
        }
    }

    public function storeLog($module, $action, $id = null)
    {
        $audit = new AuditTrail();
        $audit->module      = $module;
        $audit->module_id   = $id;
        $audit->action      = $action;
        $audit->browser     = \Browser::browserName();
        $audit->ip          = Request::ip();

        $this->audits()->save($audit);
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
