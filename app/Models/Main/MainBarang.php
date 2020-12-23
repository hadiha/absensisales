<?php 
namespace App\Models\Main;

use App\Models\Master\Barang;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MainBarang extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'trans_barang';
    protected $fillable = [
      'barang_id', 'tanggal', 'sale_in', 'sale_out', 'stock', 'foto'
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
    
    public function scopeForGrid($query)
    {
        return $query->when(!request()->has('order'), function ($q) {
                        return $q->orderBy('created_at', 'desc');
                    })
                    ->when($kode = request()->kode, function ($q) use ($kode) {
                        return $q->whereHas('item', function($w) use ($kode){
                          $w->where('kode', 'like', '%' . $kode . '%');
                        });
                    })
                    ->when($name = request()->name, function ($q) use ($name) {
                      return $q->whereHas('item', function($w) use ($name){
                        $w->where('name', 'like', '%' . $name . '%');
                      });
                    });
    }
    
    public static function createByRequest($request)
    {
        DB::beginTransaction();
        try {
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
	
	
}