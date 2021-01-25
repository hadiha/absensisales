<?php

namespace App\Models\Authentication;

use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // call traits
    use RaidModel;
    use Utilities;
    
    protected $table = 'notifications';
    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'url',
        'user_id',
        'read_at',
    ];

    public function target()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
