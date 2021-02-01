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
        DB::beginTransaction();
        try {
          $file = [];
          if(isset($request->filespath)){
              if(count($request->filespath) > 0){
                  foreach ($request->filespath as $k => $value) {
                      $file[$k]['fileurl'] = $value;
                      $file[$k]['filename'] = $request->filename[$k];
                  }
              }
          }

            $record = new self();
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
      if(isset($request->filespath)){
        if(count($request->filespath) > 0){
          foreach ($request->filespath as $key => $value) {
                  if($request->filename[$key])
                  {
                      $saveFile['filename'] = $request->filename[$key];
                  }

                  $saveFile['fileurl'] = $value;
                  $saveFile['barang_id'] = $this->id;

                  $recordFile = new DataFile();
                  if(isset($request->fileid[$key]))
                  {
                      $recordFile = DataFile::where('fileurl', $value)->where('barang_id', $this->id)->first();
                  }
                  $recordFile->fill($saveFile);
                  $recordFile->save();

                  $fileid[] = $recordFile->id;
          }

          $notExist = DataFile::whereNotIn('id', $fileid)->where('barang_id', $this->id)->get();

          if($notExist->count() > 0)
          {
                  foreach($notExist as $ne)
                  {
                      if(file_exists(storage_path().'/app/public/'.$ne->fileurl))
                      {
                              unlink(storage_path().'/app/public/'.$ne->fileurl);
                      }
                      $ne->delete();
                  }
          }
        }
      }

        $this->fill($request->all());
        $this->save();

        auth()->user()->storeLog('Laporan Barang', 'Mengupdate Laporan Barang', $this->id);

        return response([
            'status' => true,
            'record' => $this
        ]);
    }
	
}