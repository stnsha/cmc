<!DOCTYPE html>
<html>

<head>
    <title>Email Verification</title>
</head>

<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>Hi, {{ $mailData['name'] }}! Thank you for your registration.</p>
    <a href="{{ route('mail.confirm', ['email' => $mailData['email']]) }}">Click here to confirm your email.</a>
    <p>See you!</p>
</body>

</html>