<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'user_id',
        'requirement_id',
        'test_case_id',
        'defect_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requirement() {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }

    public function test_case() {
        return $this->belongsTo(TestCase::class, 'test_case_id');
    }
}
