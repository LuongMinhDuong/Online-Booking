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
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $checkLogin = checkLogin($email, $password);
    if ($checkLogin['role'] == 1) {
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        sendCode($email);
        header("Location:confirm.php");
    } else {
        login($email, $password);
    }
}
?>

<body>
    <div id="wrapper">
        <form method="post" id="form-login">
            <h1 class="form-heading">Login</h1>
            <!-- <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" class="form-input" placeholder="Tên đăng nhập">
            </div> -->
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" class="form-input" placeholder="Email">
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="form-input" placeholder="Mật khẩu">
                <div id="eye">
                    <i class="far fa-eye"></i>
                </div>
            </div>
            <a href="../index.php">Trở về trang chủ</a>
            <input type="submit" name="login" value="Đăng nhập" class="form-submit">
        </form>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="js/app.js"></script>

</html>