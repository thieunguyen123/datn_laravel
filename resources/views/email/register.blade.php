<!DOCTYPE html>
<html>
<head>
    <title>Thông báo tạo bài post thành công</title>
    <style>
        .success-message {
            background-color: #d4edda;
            color: yellowgreen;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .link {
            color: red;
        }
    </style>
</head>
<body>
    <div class="success-message">
        <h2>Hi {{$nameUser}}, Chúc mừng bạn đã tạo tài khoản thành công!</h2>
        <h4>Đây là thông tin tài khoản của bạn: </h4>
        <p>Email: {{$nameEmail}} </p>
        <p>Password: {{$password}} </p>
    </div>
</body>
</html>
