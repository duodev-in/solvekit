<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply from SolveKit</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; padding: 32px 16px; color: #111827;">
    <div style="max-width: 640px; margin: 0 auto; background: white; border-radius: 16px; padding: 24px; border: 1px solid #e5e7eb;">
        <p style="margin: 0 0 16px; font-size: 14px; color: #4b5563;">Hi {{ $message->name }},</p>

        <div style="font-size: 16px; line-height: 1.7; color: #111827; white-space: pre-line;">
            {{ $replyBody }}
        </div>

        <p style="margin-top: 24px; font-size: 14px; color: #4b5563;">
            Best regards,<br>
            The SolveKit Team
        </p>
    </div>
</body>
</html>
