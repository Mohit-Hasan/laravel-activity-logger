<?php

namespace MohitHasan\ActivityLogger\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'loggable_type',
        'loggable_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('activity-logger.table_name', 'activity_logs'));
        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->belongsTo(config('activity-logger.user_model'));
    }

    public function loggable()
    {
        return $this->morphTo();
    }
}
