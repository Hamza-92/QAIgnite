<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Case Approval Request</title>
</head>
<body>
    <h2>Test Case Approval Request</h2>
    <p>Dear {{ $approver->name }},</p>
    <p>
        A new test case titled <strong>{{ $testCase->tc_name }}</strong> has been submitted and requires your approval.
    </p>
    <p>
        Submitted by: {{ $user->username }}<br>
        Submission Date: {{ $testCase->created_at->format('Y-m-d H:i:s') }}<br>
    </p>
    <p>
        Please review the test case and take the necessary action.
    </p>
    <p>
        <a href="{{ route('test-case.detail', [$testCase->id]) }}">View Test Case</a>
    </p>
    <p>
        Thank you,<br>
        {{$user->organization->name}} Team
    </p>
</body>
</html>
