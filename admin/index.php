<?php
include 'header.php';
include '../conn.php'
?>

<?php
echo '<h1>Thống kê người dùng hệ thống</h1>';
$sql = "SELECT id_account, username, email, phone, role FROM accounts";
$role = '';
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['role'] == 1) {
            $role = 'Admin';
        } else if ($row['role'] == 2) {
            $role = 'Staff';
        } else {
            $role = 'user';
        }
        echo "- Id: " . $row["id_account"] . " - Họ và Tên: " . $row["username"] . " - Email: " . $row["email"] . " - Số điện thoại: " . $row["phone"] . " - Vai trò: " . $role . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<?php
include 'footer.php';
?>