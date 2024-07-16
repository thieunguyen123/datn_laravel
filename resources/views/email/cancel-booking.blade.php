<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Cancellation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            text-align: center;
            background-color: #e74c3c;
            color: #fff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
        }

        .content p {
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            background-color: #e74c3c;
            color: #fff;
            padding: 10px;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Booking Cancellation</h2>
        </div>
        <div class="content">
            <p>We regret to inform you that your booking has been canceled.</p>
            <p><strong>Date:</strong> {{ $date }}</p>
            <p><strong>Time:</strong> {{ $time }}</p>
            <p><strong>Court Name:</strong> {{ $nameBadmintonCourt }}</p>
            <p><strong>Court Address:</strong> {{ $addressBadmintonCourt }}</p>
            <p>If you have any questions or concerns, please feel free to contact us.</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Your Sports Facility</p>
        </div>
    </div>
</body>
</html>

