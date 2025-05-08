<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bills GlowImplant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .invoice-container {
            max-width: 600px;
            width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .invoice-header {
            color: #007bff;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .invoice-details {
            text-align: left;
            margin: 20px 0;
        }

        .invoice-details p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .invoice-table th {
            background: #007bff;
            color: white;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            color: #f9b744;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        @media (max-width: 600px) {
            .invoice-container {
                padding: 15px;
            }

            .invoice-header {
                font-size: 20px;
            }

            .invoice-details p {
                font-size: 14px;
            }

            .invoice-table th, .invoice-table td {
                padding: 8px;
            }

            .total {
                font-size: 16px;
            }
        }
        .countact{
            display:flex;
            justify-content:space-between;
        }
        .countact i{
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="">
        <div class="invoice-header">Purchase invoice</div>
        <div class="invoice-details">
            <p><strong>Purchase invoice:</strong> {{ $payment->invoice_number }}</p>
            <p><strong>the date:</strong> {{ $payment->created_at }}</p>
            <p><strong>Customer name:</strong> {{ $payment->name }}</p>
            <p><strong>Agany:</strong>Mohamad</p>
            <p><strong>Email Agancy:</strong>test@test.com</p>
            <p><strong>You pay:</strong>{{ $payment->amount . " " . $payment->currency }}</p>
        </div>
        <hr>
        <div class="total">Thank you for your business.</div>
        <hr>
        <div class="countact">
            <span><i class="fas fa-envelope"></i> info@glowimpalnt.com</span>
            <span><i class="fas fa-phone"></i> 09909090990</span>
        </div>
    </div>
</body>
</html>
