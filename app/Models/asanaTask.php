<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class asanaTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ref',
        'section_id',
        'gid',
        'taskName',
        'deleted_by',
    ];

    public function detailTask()
    {
        return $this->hasOne(asanaDetailTask::class, 'task_id', 'id');
    }
    public function subTask()
    {
        return $this->hasMany(asanaSubTask::class, 'task_id', 'id');
    }
    /**
     * The "booting" function of model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });

        static::deleting(function ($task) {
            // Hapus semua detailtask yang terkait
            $task->detailTask()->delete();
            $task->subTask()->delete();
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
