<?php
namespace App\Models\Traits;

use App\Models\Authentication\User;
use DB;

trait RaidModel
{
    public static function boot()
    {
        parent::boot();

        if (auth()->check()) {
            if (\Schema::hasColumn(with(new static )->getTable(), 'updated_by')) {
                static::saving(function ($table) {
                    $table->updated_by = auth()->user()->id;
                });
            }

            if (\Schema::hasColumn(with(new static )->getTable(), 'created_by')) {
                static::creating(function ($table) {
                    $table->updated_by = null;
                    $table->updated_at = null;
                    $table->created_by = auth()->user()->id;
                });
            }
        }

        // insert to log
        if($log_table = (new static)->log_table){
            static::saved(function ($table) {
                $log = $table->attributes;
                $log[$table->log_table_fk] = $log['id'];
                unset($log['id']);

                DB::table($table->log_table)->insert($log);
            });

            static::deleting(function ($table) {
                $log = $table->attributes;
                $log[$table->log_table_fk] = $log['id'];
                unset($log['id']);

                DB::table($table->log_table)->insert($log);
            });
        }
    }

    /*-----------*/
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function entryBy()
    {
        return isset($this->creator) ? $this->creator->name : '[System]';
    }

    /* save data */
    public static function saveData($request, $identifier = 'id')
    {
        $record = static::prepare($request, $identifier);
        $record->fill($request);
        $record->save();

        return $record;
    }

    public static function prepare($request, $identifier = 'id')
    {
        $record = new static;

        if ($request->has($identifier) && $request->get($identifier) != null && $request->get($identifier) != 0) {
            $record = static::find($request->get($identifier));
        }

        return $record;
    }

}
