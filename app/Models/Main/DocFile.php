<?php 
namespace App\Models\Main;

use App\Models\Authentication\User;
use App\Models\Master\Barang;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DocFile extends Model
{
  // call traits
    use RaidModel;
    use Utilities;

    protected $table = 'trans_file_documentasi';
    protected $fillable = [
      'doc_id', 'filename', 'fileurl'
    ];

    // Relations
    public function document()
    {
        return $this->belongsTo(Documentasi::class, 'doc_id');
    }

}