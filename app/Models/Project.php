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
        'has_asana',
        'cust_id',
        'customerType',
        'projectName',
        'noContract',
        'contractDate',
        'po',
        'noPo',
        'datePo',
        'projectValue',
        'projectValuePPN',
        'overAllProg',
        'projectType',
        'partnerId',
        'sales',
        'pmName',
        'coPm',
        'sponsor',
        'contractStart',
        'contractEnd',
        'deleted_by'
    ];
    public function asana()
    {
        return $this->hasMany(asanaProject::class, 'projectId', 'id');
    }
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
    public function topProject()
    {
        return $this->hasMany(topProject::class, 'projectId', 'id');
    }
    public function sponsor()
    {
        return $this->belongsToMany(projectSponsor::class, 'project_sponsors', 'projectId', 'sponsorId');
    }
    public function sponsors()
    {
        return $this->hasMany(projectSponsor::class, 'projectId', 'id');
    }
    public function inScope()
    {
        return $this->hasMany(inScope::class, 'projectId', 'id');
    }
    public function outScope()
    {
        return $this->hasMany(outScope::class, 'projectId', 'id');
    }

    public function timeline()
    {
        return $this->hasMany(scopeProject::class, 'projectId', 'id');
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
