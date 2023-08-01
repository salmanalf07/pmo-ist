<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'name',
        'ktp',
        'npwp',
        'norek',
        'nohp',
        'level',
        'divisi',
        'company',
        'penempatan',
        'direct_manager',
        'role',
        'spesialisasi',
        'pkwt_start',
        'pkwt_end',
        'email_ist',
        'email',
        'status',
        'keterangan',
    ];
    /**
     * The "booting" function of model
     *
     * @return void
     */
    public function divisi()
    {
        return $this->belongsTo(division::class, 'divisi', 'id');
    }
    public function department()
    {
        return $this->belongsTo(department::class, 'department', 'id');
    }
    public function manager()
    {
        return $this->belongsTo(employee::class, 'direct_manager', 'id');
    }
    public function memberProject()
    {
        return $this->hasMany(memberProject::class, 'employee', 'id');
    }
    public function levels()
    {
        return $this->belongsTo(skillLevel::class, 'level', 'id');
    }
    public function roles()
    {
        return $this->belongsTo(roleEmployee::class, 'role', 'id');
    }
    public function region()
    {
        return $this->belongsTo(locationEmployee::class, 'penempatan', 'id');
    }
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
