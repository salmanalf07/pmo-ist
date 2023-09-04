<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class partnerProject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'projectId',
        'partner',
        'rolePartner',
        'accesPartner',
        'partnerCorp',
        'stdatePartner',
        'eddatePartner',
        'planManPartner',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'projectId', 'id');
    }
    public function roles()
    {
        return $this->belongsTo(roleEmployee::class, 'rolePartner', 'id');
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
