<?php 
namespace App\Models\Main;

use App\Models\Authentication\User;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Absensi extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'trans_kehadiran';
    protected $fillable = [
      'pegawai_id', 'date_in', 'date_out', 'status', 'koordinat', 'keterangan'
    ];

    protected $dates = [
        'date_in', 'date_out'
    ];
    // protected $preventAttrSet = false;

    // Accessors & Mutators
    // public function setDateInAttribute($value)
    // {
    //     if ($this->preventAttrSet) {
    //         return $this->attributes['date_in'] = $value;
    //     } else {
    //         return $this->attributes['date_in'] = !is_null($value) ? Carbon::createFromFormat('d/m/Y H:i:s', $value) : null;
    //     }
    // }

    // public function setDateOutAttribute($value)
    // {
    //     if ($this->preventAttrSet) {
    //         return $this->attributes['date_out'] = $value;
    //     } else {
    //         return $this->attributes['date_out'] = !is_null($value) ? Carbon::createFromFormat('d/m/Y H:i:s', $value) : null;
    //     }
    // }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function scopeForGrid($query)
    {
        $to = request()->to;
        return $query->when(!request()->has('order'), function ($q) {
                        return $q->orderBy('created_at', 'desc');
                    })
                    ->when($name = request()->name, function ($q) use ($name) {
                        $q->whereHas('user', function($w) use ($name){
                            return $w->where('name', 'like', '%' . $name . '%');
                        });
                    })
                    ->when($from = request()->from, function ($q) use ($from, $to) {
                        return $q->whereBetween('date_in', [$from, $to]);
                    });
    }
    
    public static function createByRequest($request)
    {
        DB::beginTransaction();
        try {
            $record = new Absensi();
            $record->fill($request->all());
            $record->save();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data'    => $record
        ]);
    }

    public function updateByRequest($request)
    {
        DB::beginTransaction();
        try {
            
            if($request->time_in != null){
                $in = Carbon::createFromFormat('d/m/Y G:i', $request->tanggal.' '.$request->time_in);
                $this->date_in = $in;
            }
            if($request->time_out != null){
                $out = Carbon::createFromFormat('d/m/Y G:i', $request->tanggal.' '.$request->time_out);
                $this->date_out = $out;
            }else{
                $this->date_out = null;
            }
            $this->keterangan = $request->keterangan;
            $this->status = $request->status;
            $this->save();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data'    => $this
        ]);
    }
    
    public function statusLabel()
    {
        switch ($this->status) {
            case 'hadir':
                return '<a class="ui small green tag label">Hadir</a>';
                break;
            case 'izin':
                return '<a class="ui small teal tag label">Izin</a>';
                break;
            case 'sakit':
                return '<a class="ui small blue tag label">Sakit</a>';
                break;
            case 'cuti':
                return '<a class="ui small yellow tag label">Cuti</a>';
                break;
            
            default:
                return '<a class="ui small red tag label">Tanpa Keterangan</a>';
                break;
        }
    }

    public function sakit()
    {
        # code...
    }

}