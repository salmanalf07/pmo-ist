<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'noProject',
        'cust_id',
        'customerType',
        'projectName',
        'noContract',
        'contractDate',
        'po',
        'noPo',
        'datePo',
        'projectValue',
        'projectType',
        'partnerId',
        'sales',
        'pmName',
        'coPm',
        'sponsor',
        'contractStart',
        'contractEnd',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
    public function pm()
    {
        return $this->belongsTo(employee::class, 'pmName', 'id');
    }
    public function coPm()
    {
        return $this->belongsTo(employee::class, 'pmName', 'id');
    }
    public function sponsors()
    {
        return $this->belongsTo(employee::class, 'sponsor', 'id');
    }
    public function saless()
    {
        return $this->belongsTo(employee::class, 'sales', 'id');
    }
    public function partner()
    {
        return $this->belongsTo(Customer::class, 'partnerId', 'id');
    }
    public function memberProject()
    {
        return $this->hasMany(memberProject::class, 'projectId', 'id');
    }
    public function partnerProject()
    {
        return $this->hasMany(partnerProject::class, 'projectId', 'id');
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
