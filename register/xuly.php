<?php
include('../conn.php');

// $sql = "INSERT INTO accounts (username, password, email, phone) VALUES ('$username', '$password', '$email', '$phone')";
// if ($conn->query($sql) === TRUE) {
//     $last_id = $conn->insert_id;
//     echo '<script>alert("Đăng ký tài khoản thành công!")</script>';
//     header("refresh: 1; url = ../index.php");
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }
// }

function sendLink($email, $now)
{
    global $last_id;
    $token = bin2hex($last_id . '_' . $now);
    $link = 'http://localhost/Online%20Booking/register/verify.php?token=' . $token;
    // $url = '<a href="' . $link . '">' . $link . '</a>';

    $to = $email;
    $subject = "Email verification";
    $message = "'<p>Your verification link is: <b>' . $link . '</b></p>';";
    $headers = "From: duong40541@gmail.com" . "\r\n" .
        "CC: somebodyelse@example.com";
    mail($to, $subject, $message, $headers);
}
