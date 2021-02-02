<?php 
namespace App\Models\Main;

use App\Models\Master\Barang;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Laporan extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'trans_barang';
    protected $fillable = [
      'barang_id', 'tanggal', 'sale_in', 'sale_out', 'stock'
    ];

    protected $dates= [
      'tanggal'
    ];

    // Accessors & Mutators
    public function setTanggalAttribute($value)
    {
        if ($this->preventAttrSet) {
            return $this->attributes['tanggal'] = $value;
        } else {
            return $this->attributes['tanggal'] = !is_null($value) ? Carbon::createFromFormat('d/m/Y', $value) : null;
        }
    }

    public function item()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function files(){
    	  return $this->hasMany(DataFile::class, 'barang_id');
    }
    
    public function scopeForGrid($query)
    {
        return $query->withCount('files')->when(!request()->has('order'), function ($q) {
                        return $q->orderBy('created_at', 'desc');
                    })
                    ->when($month = request()->month, function ($q) use ($month) {
                      return $q->whereMonth('created_at', Carbon::createFromFormat('m', $month)->format('m'))
                              ->whereYear('created_at', Carbon::createFromFormat('Y', request()->year)->format('Y'));
                  })
                  ->where('created_by', auth()->user()->id);
    }
    
    public static function createByRequest($request)
    {
        // dd($request->filespath[0]->getClientOriginalName());
        DB::beginTransaction();
        try {
            $file = [];
            if(isset($request->filespath)){
                if(count($request->filespath) > 0){
                    foreach ($request->filespath as $k => $value) {
                        $temp = $value->storeAs('fileupload', md5($value->getClientOriginalName().Carbon::now()->format('Ymdhisu')).'.'.$value->getClientOriginalExtension(), 'public');
                        $filetemp = new DataFile();
                        $filetemp->fileurl = $temp;
                        $filetemp->filename = $value->getClientOriginalName();
                        $file[$k] = $filetemp;
                    }
                }
            }

            $record = new self();
            $record->fill($request->all());
            $record->save();
            $record->files()->saveMany($file);
            
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
    $saveFile = [];
    if(isset($request->filespath)){
        foreach($this->files as $k => $file){
            if(file_exists(storage_path().'/app/public/'.$file->fileurl))
            {
                unlink(storage_path().'/app/public/'.$file->fileurl);
            }
            $file->delete();
        };

        if(count($request->filespath) > 0){
            foreach ($request->filespath as $k => $value) {
                $temp = $value->storeAs('fileupload', md5($value->getClientOriginalName().Carbon::now()->format('Ymdhisu')).'.'.$value->getClientOriginalExtension(), 'public');
                $filetemp = new DataFile();
                $filetemp->fileurl = $temp;
                $filetemp->filename = $value->getClientOriginalName();
                $saveFile[$k] = $filetemp;
            }
        }
    }

        $this->fill($request->all());
        $this->save();
        $this->files()->saveMany($saveFile);

        auth()->user()->storeLog('Laporan Barang', 'Mengupdate Laporan Barang', $this->id);

        return response([
            'status' => true,
            'record' => $this
        ]);
    }
	
}