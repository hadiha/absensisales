<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
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
