<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiTestGeneration extends Model
{
    protected $fillable = [
        'user_id', 'prompt', 'status', 'response', 'error_message'
    ];

    protected $casts = [
        'response' => 'array',
    ];
}
