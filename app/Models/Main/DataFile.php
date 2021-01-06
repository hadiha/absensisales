<?php 
namespace App\Models\Main;

use App\Models\Authentication\User;
use App\Models\Master\Barang;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataFile extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'trans_file_barang';
    protected $fillable = [
      'barang_id', 'filename', 'fileurl'
    ];

    // Relations
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

}