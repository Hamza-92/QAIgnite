<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCycle extends Model
{

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'visibility',
        'project_id',
        'build_id',
        'test_plan_id',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function build()
    {
        return $this->belongsTo(Build::class);
    }
    public function testPlan()
    {
        return $this->belongsTo(TestPlan::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function testCases()
    {
        return $this->belongsToMany(TestCase::class, 'test_case_test_cycle')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function getResultCountsAttribute()
    {
        $total = $this->testCases()->count();

        $passed = $this->testCases()->wherePivot('status', 'Passed')->count();
        $failed = $this->testCases()->wherePivot('status', 'Failed')->count();
        $notRun = $this->testCases()->wherePivot('status', 'Not Executed')->count();


        return [
            'passed' => $passed,
            'failed' => $failed,
            'not_executed' => $notRun,
        ];
    }

    public function executions()
    {
        return $this->hasMany(TestCaseExecution::class);
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, 'test_cycle_user');
    }

}
