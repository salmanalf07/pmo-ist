<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class asanaSubTask2 extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'section_id',
        'parent_uuid',
        'gid',
        'task_id',
        'ref',
        'subTaskName',
        'assignee',
        'start_on',
        'due_on',
        'permalink_url',
        'progress',
        'status',
        'deletedBy'

    ];

    public function parent()
    {
        return $this->belongsTo(asanaSubTask2::class, 'parent_uuid', 'id');
    }

    public function children()
    {
        return $this->hasMany(asanaSubTask2::class, 'parent_uuid', 'id');
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
            // Hapus children yang terkait
            $task->children()->delete();
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
