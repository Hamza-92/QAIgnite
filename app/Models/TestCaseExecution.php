<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCaseExecution extends Model
{
    protected $fillable = [
        'test_case_id',
        'test_cycle_id',
        'executed_by',
        'defect_id',
        'execution_time',
        'status',
        'comment',
    ];


    public function testCase()
    {
        return $this->belongsTo(TestCase::class, 'test_case_id');
    }
    public function testCycle()
    {
        return $this->belongsTo(TestCycle::class, 'test_cycle_id');
    }
    public function executedBy()
    {
        return $this->belongsTo(User::class, 'executed_by');
    }
    public function defect()
    {
        return $this->belongsTo(Defect::class, 'defect_id');
    }
}
