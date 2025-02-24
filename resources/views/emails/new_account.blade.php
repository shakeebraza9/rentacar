<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #333;">Welcome to Our Platform!</h2>
        <p>Dear User,</p>
        <p>We are excited to have you on board. Your account has been created successfully.</p>

        <h3>Your Login Details:</h3>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>

        <p>You can log in using the following link:</p>
        <p>
            <a href="{{ url('/login') }}" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px;">
                Login Now
            </a>
        </p>

        <p>For security reasons, we recommend that you change your password after logging in.</p>

        <p>If you have any questions, feel free to contact us.</p>

        <p>Best Regards,<br>
        The Team</p>
    </div>

</body>
</html>
