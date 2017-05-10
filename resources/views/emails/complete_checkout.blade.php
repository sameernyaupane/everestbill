<!DOCTYPE html>
<html>
<head>
    <title>Please complete your checkout process</title>
</head>
<body>
    <p>Dear {{ $user->full_name }},</p>
    <p>Please click on the following link to complete your checkout process:</p>
    <a href="{{ route('register.complete.checkout', $user->activationCode )}}">
      {{ route('register.complete.checkout', $user->activationCode )}}
    </a>
</body>
</html>
