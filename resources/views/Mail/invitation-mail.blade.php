<!DOCTYPE html>
<html>
<head>
    <title>Invitation to {{$invitation['organization_name']}}</title>
</head>
<body>
    <h2>Hello {{ $invitation['name'] }},</h2>
    <p>You have been invited to join {{ $invitation['organization_name'] }} as a {{ $invitation['role_name'] }}.</p>
    <p>Click the button below to set your password and join:</p>
    <a href="{{ route("invitation", ['token' => $invitation['token']]) }}"
       style="background-color: #0A84FF; color: white; padding: 10px 20px; text-decoration: none; display: inline-block;">
       Accept Invitation
    </a>
    <p>This link will expire in 7 days.</p>
</body>
</html>
