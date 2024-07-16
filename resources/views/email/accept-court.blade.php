<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
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
            background-color: #4CAF50;
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
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Notification: Court Approved</h2>
        </div>
        <div class="content">
            <p>Congratulations! Your badminton court has been approved.</p>
            <p><strong>Court Name:</strong> {{ $nameCourt }}</p>
            <p><strong>Court Address:</strong> {{ $addressCourt }}</p>
            <p>Thank you for choosing our facility. We look forward to seeing you!</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Your Sports Facility</p>
        </div>
    </div>
</body>
</html>
