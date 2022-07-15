<?php
include('../conn.php');
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM accounts where username = '$username' and password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
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
    // if (isset($_POST['submit'])) {
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
}
