<?php 
namespace App\Models\Master;

use App\Models\Main\Laporan;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'ref_barang';
    protected $fillable = [
      'kode', 'name', 'jumlah'
    ];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'barang_id');
    }
	
}