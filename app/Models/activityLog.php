<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class activityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $fillable = [
        'log_name',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'description',
        'properties',

    ];

    public function users()
    {
        return $this->belongsTo(user::class, 'subject_id', 'id');
    }
}
