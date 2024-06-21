<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class asanaSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ref',
        'asana_id',
        'gid',
        'sectionName',
        'start_on',
        'due_on',
        'progress',
        'status',
        'deleted_by',
    ];

    public function task()
    {
        return $this->hasMany(asanaTask::class, 'section_id', 'id');
    }
    public function newTask()
    {
        return $this->hasMany(asanaSubTask2::class, 'section_id', 'id');
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

        static::deleting(function ($section) {
            // Hapus semua detailtask yang terkait
            $section->task()->each(function ($task) {
                $task->detailTask()->delete();
                $task->subTask()->delete();
                $task->delete();
            });
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
