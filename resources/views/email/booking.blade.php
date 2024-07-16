<!DOCTYPE html>
<html>
<head>
    <title>Thông báo đặt lịch</title>
    <style>
        .success-message {
            background-color: #d4edda;
            color: yellowgreen;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="success-message">
        <h2>Hi , Bạn vừa có 1 lịch đặt sân</h2>
        <h4>Hãy vào link bên dưới xác nhận nhé 😘 </h4>
        <a href="{{config('url.confirmBooking')}}" style="background-color: #e04420; border: none; color: white; padding: 10px 25px; text-align: center; display: inline-block; font-family: Nunito, sans-serif; font-size: 18px; font-weight: bold; cursor: pointer;">Click me</a>
    </div>
</body>
</html>
