<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class weeklyReport extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'projectId',
        'periode',
        'currentStage',
        'traficLight',
        'PMCust',
        'issuedDate'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'projectId', 'id');
    }

    public function riskIssue()
    {
        return $this->hasMany(WReportRiskIssue::class, 'wReportId', 'id');
    }
    public function risk()
    {
        return $this->hasMany(WReportRiskIssue::class, 'wReportId', 'id')
            ->where('type', '=', 'risk');
    }
    public function issue()
    {
        return $this->hasMany(WReportRiskIssue::class, 'wReportId', 'id')
            ->where('type', '=', 'issue');
    }

    public function milestone()
    {
        return $this->hasMany(WReportMilestone::class, 'wReportId', 'id');
    }

    public function projectProgress()
    {
        return $this->hasOne(wReportProjectProgres::class, 'wReportId', 'id');
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
