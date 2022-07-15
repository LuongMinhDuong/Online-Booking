<?php
include('../conn.php');

$sql = "INSERT INTO accounts (username, password, email, phone) VALUES ('$username', '$password', '$email', '$phone')";
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Đăng ký tài khoản thành công!")</script>';
    header("refresh: 1; url = ../index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
// }
