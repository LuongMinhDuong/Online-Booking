<?php
include('../conn.php');

session_start();
function login($email, $password)
{
    global $conn;
    $sql = "SELECT * FROM accounts where email = '$email' and password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION['check_login'] = true;
        $_SESSION['user'] = $data['role'];
        $_SESSION['id'] = $data['id_account'];
        $_SESSION['all'] = $data;
        if ($data['role'] == '1') {
            // $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            echo '<script>alert("Đăng nhập Admin thành công!")</script>';
            header("refresh: 1; url = ../admin/index.php");
            exit();
        } else if ($data['role'] == '2') {
            echo '<script>alert("Đăng nhập Staff thành công!")</script>';
            header("refresh: 1; url = ../admin/index.php");
            exit();
        } else if ($data['role'] == '3') {
            $_SESSION['user'] = $data;
            echo '<script>alert("Đăng nhập User thành công!")</script>';
            header("refresh: 1; url = ../index.php");
            exit();
        }
    } else {
        echo '<script>alert("Đăng nhập không thành công! Sau thông tin đăng nhập hoặc trường thông tin đang trống! Bạn sẽ trở về trang đăng nhập")</script>';
        header("refresh: 1; url = form.php");
        exit();
    }
}

function checkLogin($email, $password)
{
    global $conn;
    $sql = "SELECT * FROM accounts where email = '$email' and password = '$password' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data;
    }
}


function sendCode($email)
{
    global $conn;
    $verification_code = random_int(100000, 999999);

    $getCode = $conn->query("SELECT * FROM email_code WHERE user_email = '$email'");
    if ($getCode) {
        $conn->query("UPDATE email_code SET code = '$verification_code' WHERE user_email = '$email'");
    } else {
        $sql = "INSERT INTO email_code(code, user_email) VALUES ('$verification_code', '$email')";
        $result = $conn->query($sql);
    }


    $to = $email;
    $subject = "Email verification";
    $message = "'<p>Your verification code is: <b>' . $verification_code . '</b></p>';";
    $headers = "From: duong40541@gmail.com" . "\r\n" .
        "CC: somebodyelse@example.com";
    mail($to, $subject, $verification_code, $message, $headers);
}

function confirmCode($email, $code)
{
    global $conn;
    $sql = "SELECT * FROM email_code where user_email = '$email' and code = '$code' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data;
    }
}

// testMail();
// if (isset($_POST['login'])) {
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $sql = "SELECT * FROM accounts where email = '$email'";
//     $result = $conn->query($sql);
//     if ($result->num_rows > 0) {
//         die('Email not found.');
//     }
//     $user = mysqli_fetch_object($result);
//     if (!password_verify($password, $user->password)) {
//         die("Password is not correct");
//     }
//     if ($user->email_verified_at == null) {
//         die("Please verify your email <a href='email-verification.php?email=" . $email . "'>from here</a>");
//     }
//     echo "<p>Your login logic here</p>";
//     exit();
// }
