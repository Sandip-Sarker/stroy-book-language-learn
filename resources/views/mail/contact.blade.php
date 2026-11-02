<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }
        .header h2 {
            margin: 0;
            color: #333;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            margin-top: 20px;
        }
        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            margin-top: 15px;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .info-row strong {
            display: inline-block;
            width: 100px;
            color: #555;
        }
        .message-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #f4f8ff;
            border-left: 4px solid #3490dc;
            border-radius: 4px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            text-align: center;
            color: #777777;
            border-top: 1px solid #eaeaea;
            padding-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>New Contact Form Submission</h2>
        <p>{{ $systemSettings?->system_name ?? config('app.name') }}</p>
    </div>

    <div class="content">
        <p>Hello Admin,</p>

        <p>You have received a new contact request from your website. The details are below:</p>

        <div class="info-box">
            <div class="info-row">
                <strong>Name:</strong> {{ $contact_us->name ?? 'N/A' }}
            </div>
            <div class="info-row">
                <strong>Email:</strong> {{ $contact_us->email ?? 'N/A' }}
            </div>
            <div class="info-row">
                <strong>Subject:</strong> {{ $contact_us->subject ?? 'N/A' }}
            </div>
        </div>

        <div class="message-box">
            <strong>Message:</strong>
            <p>{{ $contact_us->message ?? 'N/A' }}</p>
        </div>

        <p>Please respond to the user as soon as possible.</p>

        <p>Thank you,<br>
            {{ $systemSettings?->system_name ?? config('app.name') }} Team</p>
    </div>

    <div class="footer">
        <p>{{ $systemSettings?->address ?? 'N/A' }}</p>
        <p>© {{ date('Y') }} {{ $systemSettings?->system_name ?? config('app.name') }}. All rights reserved.</p>
    </div>
</div>

</body>
</html>
