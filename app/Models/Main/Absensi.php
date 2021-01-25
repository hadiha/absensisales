<?php 
namespace App\Models\Main;

use App\Models\Authentication\Notification;
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

    public function notif()
    {
        return $this->morphMany(Notification::class, 'target');
    }

    public function notifMorphClass()
    {
        return 'absensi';
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
    
    // untuk API
    public static function createByRequest($request)
    {
        DB::beginTransaction();
        try {
            $cek = Absensi::whereDate('date_in', Carbon::now()->format('Y-m-d'))->where('status', 'hadir')->first();

            if($cek != null){
                return response()->json([
                    'status' => 'available',
                    'success' => false,
                    'message' => 'Anda Sudah Absen Hari ini'
                ]);
            }else{
                $record = new Absensi();
                $record->fill($request->except('date_in','pegawai_id'));
                $record->pegawai_id = auth()->user()->id;
                $record->date_in = Carbon::now();
                $record->save();
                
                auth()->user()->storeLog('Absensi', 'Menginput Jam Masuk', $record->id);
                
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'gagal',
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'sukses',
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data'    => $record
        ]);
    }

    public static function createOut($request)
    {
        DB::beginTransaction();
        try {
            $record = Absensi::where('pegawai_id', auth()->user()->id)
                                ->where('status', 'hadir')
                                ->whereDate('date_in', Carbon::now()->format('Y-m-d'))->first();
            if($record == null){
                return response()->json([
                    'status'  => 'empty',
                    'success' => true,
                    'message' => 'Upps,, Anda belum Absen Masuk'
                ]);
            } else{
                $record->date_out = Carbon::now();
                $record->save();
                
                auth()->user()->storeLog('Absensi', 'Menginput Jam Pulang', $record->id);
                
                DB::commit();
            };
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status'  => 'gagal',
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status'  => 'berhasil',
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data'    => $record
        ]);
    }


    public static function pengajuan($request)
    {
        DB::beginTransaction();
        try {
            $record = new Absensi();
            $record->fill($request->all());
            $record->save();

            auth()->user()->storeLog('Absensi', 'Membuat Pengajuan '.$record->status , $record->id);

            $notif = new Notification();
            $notif->type            = auth()->user()->name. ' Membuat Permohonan '. ucfirst($record->status);
            $notif->notifiable_type = $record->notifMorphClass();
            $notif->notifiable_id   = $record->id;
            $notif->user_id         = auth()->user()->id;
            $notif->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                // 'message' => 'Gagal Menyimpan data',
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

            auth()->user()->storeLog('Monitoring', 'Mengupdate data Absensi di Monitoring', $this->id);
            
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

    public static function getDash($status, $year)
    {
        $record = Absensi::where('status', $status)
                    ->whereMonth('created_at', $year->format('m'))
                    ->whereYear('created_at', $year->format('Y'))->count();

        return $record;
    }

}