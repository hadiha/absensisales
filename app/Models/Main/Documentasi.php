<?php 
namespace App\Models\Main;

use App\Models\Master\Area;
use App\Models\Master\Barang;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Documentasi extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'trans_documentasi';
    protected $fillable = [
      'client_id', 'area_id', 'date', 'keterangan',
    ];

    protected $dates= [
      'date'
    ];

    // Accessors & Mutators
    public function setDateAttribute($value)
    {
        if ($this->preventAttrSet) {
            return $this->attributes['date'] = $value;
        } else {
            return $this->attributes['date'] = !is_null($value) ? Carbon::createFromFormat('d/m/Y', $value) : null;
        }
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function files(){
    	  return $this->hasMany(DocFile::class, 'doc_id');
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
                        $temp = $value->storeAs('document', md5($value->getClientOriginalName().Carbon::now()->format('Ymdhisu')).'.'.$value->getClientOriginalExtension(), 'public');
                        $filetemp = new DocFile();
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

            auth()->user()->storeLog('Dokumentasi Barang', 'Menginput Dokumentasi Barang', $record->id);
            
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
                if($value != null){
                    $temp = $value->storeAs('fileupload', md5($value->getClientOriginalName().Carbon::now()->format('Ymdhisu')).'.'.$value->getClientOriginalExtension(), 'public');
                    $filetemp = new DocFile();
                    $filetemp->fileurl = $temp;
                    $filetemp->filename = $value->getClientOriginalName();
                    $saveFile[$k] = $filetemp;
                }
            }
        }
    }

        $this->fill($request->all());
        $this->save();
        $this->files()->saveMany($saveFile);

        auth()->user()->storeLog('Dokumentasi Barang', 'Mengupdate Dokumentasi Barang', $this->id);

        return response([
            'status' => true,
            'record' => $this
        ]);
    }
	
}