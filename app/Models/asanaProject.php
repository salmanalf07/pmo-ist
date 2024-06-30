<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class asanaProject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gid',
        'archived',
        'projectId',
        'projectName',
        'owner',
        'sales',
        'startDate',
        'dueDate',
        'actStartDate',
        'actDueDate',
        'progress',
        'permalink_url',
        'status',
        'sync_today'
    ];
    public function section()
    {
        return $this->hasMany(asanaSection::class, 'asana_id', 'id');
    }
    public function pm()
    {
        return $this->belongsTo(asanaUser::class, 'owner', 'gid');
    }
    public function saless()
    {
        return $this->belongsTo(asanaUser::class, 'sales', 'gid');
    }
    public function statuss()
    {
        return $this->belongsTo(asanaStatus::class, 'status', 'code');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'projectId', 'id');
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
