<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.password_reset_subject') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            font-size: 22px;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }
        .btn-reset {
            display: inline-block;
            padding: 10px 25px;
            background-color: #3490dc;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
        /* Responsive Design */
        @media (max-width: 600px) {
            .email-container {
                padding: 15px;
            }
            h2 {
                font-size: 20px;
            }
            .btn-reset {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>{{ __('emails.password_reset_title') }}</h2>
        <p>{{ __('emails.password_reset_message') }}</p>
        <a href="{{ $resetUrl }}" class="btn-reset">{{ __('emails.password_reset_button') }}</a>
        <div class="footer">
            <p>{{ __('emails.password_reset_ignore') }}</p>
        </div>
    </div>
</body>
</html>
