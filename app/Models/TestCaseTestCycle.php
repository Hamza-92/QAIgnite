<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCaseTestCycle extends Model
{
    protected $table = 'test_case_test_cycle';

    protected $fillable = [
        'test_cycle_id',
        'test_case_id',
        // add any additional fields here
    ];

    // Relationships (optional)
    public function testCycle()
    {
        return $this->belongsTo(TestCycle::class);
    }

    public function testCase()
    {
        return $this->belongsTo(TestCase::class);
    }
}
