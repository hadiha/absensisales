<?php

namespace App\Models\Authentication;

use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    // call traits
    use RaidModel;
    use Utilities;
    
    protected $table = 'sys_audit_trail';
    protected $fillable = [
        'user_id',
        'module',
        'module_id',
        'action',
        'link',
        'ip',
        'browser',
    ];

    public const ACTIONS = [
        'login',
        'logout',
        'access',
        'create',
        'read',
        'update',
        'delete',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
