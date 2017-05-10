<!DOCTYPE html>
<html>
<head>
    <title>Activate your account</title>
</head>
<body>
    <p>Dear {{ $user->full_name }},</p>
    <p>Please click on the following link to activate your account:</p>
    <a href="{{ route('register.activate', $user->activationCode )}}">
      {{ route('register.activate', $user->activationCode )}}
    </a>
</body>
</html>
