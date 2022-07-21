<?php
include 'xuly.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <title>Trang đăng nhập</title>
</head>
<?php
if (isset($_POST['code'])) {
    $code = $_POST['code'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $confirmCode = confirmCode($email, $code);

    if ($code == $confirmCode['code']) {
        login($email, $password);
    } else {
        echo '<script>alert("Mã OTP không đúng! Vui lòng nhập lại")</script>';
    }
}
?>

<body>
    <div id="wrapper">
        <form method="post" id="form-login">
            <h1 class="form-heading">Xác thực OTP</h1>
            <!-- <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" class="form-input" placeholder="Tên đăng nhập">
            </div> -->
            <div class="form-group">
                <input type="text" name="code" class="form-input">
            </div>
            <a href="../index.php">Trở về trang chủ</a>
            <input type="submit" name="confirm" value="Đăng nhập" class="form-submit">
        </form>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="js/app.js"></script>

</html>