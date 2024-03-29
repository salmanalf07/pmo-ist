<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class mom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'projectId',
        'dateMom',
        'timeMom',
        'venue',
        'agenda',
        'chairedBy',
        'pmCust'
    ];

    public function discussions()
    {
        return $this->belongsTo(discussionMom::class, 'momId', 'id');
    }
    public function decisions()
    {
        return $this->belongsTo(decisionMom::class, 'momId', 'id');
    }
    public function participant()
    {
        return $this->hasMany(partMom::class, 'momId', 'id');
    }
    public function followup()
    {
        return $this->hasMany(followupMom::class, 'momId', 'id');
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
