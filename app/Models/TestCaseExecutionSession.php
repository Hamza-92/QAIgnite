<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCaseExecutionSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_case_id',
        'started_at',
        'paused_at',
        'total_paused_seconds',
        'is_running',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'paused_at' => 'datetime',
    ];
}
