<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <title>Trang đăng ký</title>
    <style type="text/css">
        .error {
            font-size: 15px;
            color: red;
        }
    </style>
</head>

<body>
    <?php
    include_once '../conn.php';
    include_once 'xuly.php';
    $usernameErr = $passwordErr = $confirmpasswordErr = $emailErr = $phoneErr  = NULL;
    $username = $password = $confirmpassword = $email = $phone = NULL;

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function test_pass($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        } else {
            return true;
        }
    }

    function testMail()
    {

        $to = "duong40541@gmail.com";
        $subject = "Email verification";
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $message = "'<p>Your verification code is: <b>' . $verification_code . '</b></p>';";
        $headers = "From: duong40541@gmail.com" . "\r\n" .
            "CC: somebodyelse@example.com";
        mail($to, $subject, $verification_code, $message, $headers);
    }

    testMail();

    function checkMailExists($conn, $email)
    {
        $sql = "SELECT * FROM accounts WHERE email = '$email'";
        $qr = $conn->query($sql);
        if ($qr->num_rows > 0) {
            return $qr->fetch_assoc();
        }
    }


    $flag = true;
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $now = date('d-m-Y H:i:s');
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $username = ($_POST['username']);
        $password = test_input($_POST['password']);
        $email = test_input($_POST['email']);
        $phone = test_input($_POST['phone']);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if (empty($_POST["username"])) {
            $usernameErr = "UserName bắt buộc nhập!";
            $flag = false;
        } else {
            $username = ($_POST["username"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
                $usernameErr = "Chỉ chứa kí tự và khoảng trắng!";
                $flag = false;
            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Password bắt buộc nhập!";
            $flag = false;
        } else {
            $password = $_POST["password"];
            if (!test_input($password))
                $passwordErr = "Password không được để trống!";
            $flag = false;
        }

        if (empty($_POST["confirmpassword"])) {
            $comfirmpasswordErr = "Confirm Password bắt buộc nhập!";
            $flag = false;
        } else {
            $confirmpassword = $_POST["confirmpassword"];
            if ($confirmpassword != $password)
                $confirmpasswordErr = "Không khớp với Passwords, vui lòng kiểm tra lại!";
            $flag = false;
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email không được để trống!";
            $flag = false;
        } elseif (checkMailExists($conn, $email)) {
            $emailErr = "Email đã tồn tại! Vui lòng nhập Email khác";
            $flag = false;
        } else {
            $email = test_input($_POST["email"]);
        }

        if (empty($_POST["phone"])) {
            $phoneErr = "Phone không được để trống!";
            $flag = false;
        } else {
            $phone = test_input($_POST["phone"]);
        }
        if ($flag == true) {
            $sql = "INSERT INTO accounts (username, password, email, phone) VALUES ('$username', '$password_hash', '$email', '$phone')";
            if ($conn->query($sql) === true) {
                $last_id = $conn->insert_id;
                sendLink($email, $now);
                echo '<script>alert("Đăng ký tài khoản thành công!")</script>';
                header("refresh: 1; url = ../index.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="card pt-2 mx-auto" style="max-width: 30rem;">
            <div class="card-header" style="font-size: 25px;
			font-style: italic;">
                <header>Trang đăng ký tài khoản</header>
            </div>
            <div class="card-body">
                <div class="card-text mb-2">
                    Username* : <input type="text" name="username" class="form-control" placeholder="Nhập username" value="<?= $username; ?>">
                    <span class="error"> <?= $usernameErr; ?></span>
                </div>
                <div class="card-text mb-2">
                    Password* : <input type="password" name="password" class="form-control" placeholder="Nhập password" value="<?= $password; ?>">
                    <span class="error"> <?= $passwordErr; ?></span>
                </div>
                <div class="card-text mb-2">
                    Confirm Password* : <input type="password" name="confirmpassword" class="form-control" placeholder="Nhập lại password" value="<?= $confirmpassword; ?>">
                    <span class="error"> <?= $confirmpasswordErr; ?></span>
                </div>
                <div class="card-text mb-2">
                    Email* : <input type="text" name="email" class="form-control" placeholder="Nhập email" value="<?= $email; ?>">
                    <span class="error"> <?= $emailErr; ?></span>
                </div>
                <div class="card-text mb-2">
                    Số điện thoại* : <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" value="<?= $phone; ?>">
                    <span class="error"> <?= $phoneErr; ?></span>
                </div>
            </div>
            <div class="card-footer mb-2 btn-lg">
                <input type="submit" class="btn btn-primary" name="submit" value="Đăng ký" style="margin-top:10px" />
                <input type="reset" class="btn btn-secondary" value="Nhập lại" style="margin-top:10px" />
                <a href="../index.php" class="btn btn-warning" style="margin-top:10px">Về trang chủ</a>
            </div>
        </div>
    </form>

</body>

</html>