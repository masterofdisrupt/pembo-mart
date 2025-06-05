<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Submission</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #333333;
            padding: 20px;
        }
        .email-container {
            max-width: 640px;
            margin: auto;
            background: #f9f9f9;
            border: 1px solid #eaeaea;
            padding: 30px;
            border-radius: 6px;
        }
        h1 {
            font-size: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
            color: #007bff;
        }
        .info-block {
            margin: 20px 0;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            min-width: 80px;
        }
        .message-content {
            background-color: #f1f1f1;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-top: 10px;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>📩 New Contact Form Submission</h1>

        <div class="info-block">
            <div><span class="info-label">From:</span> {{ $user['name'] ?? 'N/A' }}</div>
            <div><span class="info-label">Email:</span> {{ $user['email'] ?? 'N/A' }}</div>
            <div><span class="info-label">Subject:</span> {{ $user['subject'] ?? 'N/A' }}</div>
        </div>

        <div class="info-block">
            <strong>Message:</strong>
            <div class="message-content">
                {{ $user['message'] ?? 'No message provided' }}
            </div>
        </div>

        <div class="footer">
            This email was sent via the Pembo Mart contact form.  
            &copy; {{ date('Y') }} Pembo Mart. All rights reserved.
        </div>
    </div>
</body>
</html>
