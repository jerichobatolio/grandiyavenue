<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.5;">
    <p>Hello {{ $user->fullDisplayName() ?: $user->name }},</p>
    <p>Your verification code is:</p>
    <p style="font-size: 28px; font-weight: 700; letter-spacing: 4px; margin: 12px 0;">
        {{ $otp }}
    </p>
    <p>This code will expire in 10 minutes.</p>
    <p>If you did not create an account, you can ignore this email.</p>
</body>
</html>
