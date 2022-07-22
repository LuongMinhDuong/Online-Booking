<?php
include '../conn.php';
// session_start();

function getRoom($conn)
{
    $s = "SELECT * FROM rooms ORDER BY id DESC";
    $qr = $conn->query($s);
    $str = '';
    $status = '';
    $del = '';
    while ($r = $qr->fetch_assoc()) {
        if ($r['status'] == 0) {
            $status = 'Phòng trống';
            $del = '<a href="delete-room.php?id=' . $r['id'] . '">Delete</a>';
        } else {
            $status = 'Đã đặt';
            $del = '';
        }
        $str .= '<tr>
        <th>' . $r['room'] . '</th>
        <th>' . number_format($r['price'], 0, ',', '.') . '</th>
        <th>' . $status . '</th>
        <th><img src="../images/' . $r['image'] . '" alt="" width="50" height="50" /></th>
        <th>' . $del . '&ensp;<a href="edit-room.php?id=' . $r['id'] . '">Edit</a>&ensp;<a href="detail-room.php?id=' . $r['id'] . '">Detail</a></th>
        </tr>';
    }
    echo $str;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function test_price($price)
{
    $number    = preg_match('@[0-9]@', $price);
    if (!$number) {
        return false;
    } else {
        return true;
    }
}

function addRoom($conn)
{
    if (isset($_POST['ten']) && isset($_POST['gia']) || isset($_POST['anh'])) {
        $name = $_POST['ten'];
        $image = $_POST['anh'];
        $price = $_POST['gia'];
        $error = [];
        if (empty($_POST["ten"])) {
            $error['name'] = "<h6>Tên bắt buộc nhập!</h6>";
        } elseif (checkRoomExists($conn, $name)) {
            $error['name'] = "<h6>Tên phòng đã tồn tại!</h6>";
        } else {
            $name = test_input($_POST["ten"]);
            if (!preg_match('@[0-9]@', $name)) {
                $error['name'] = "<h6>Tên phòng bắt buộc là số!</h6>";
            }
        }

        if (empty($_POST['gia'])) {
            $error['price'] = "<h6>Vui lòng nhập giá!</h6>";
        } else {
            $price = test_input($_POST['gia']);
            if (!preg_match('@[0-9]@', $price)) {
                $error['price'] = '<h6>Chỉ được nhập số!</h6>';
            }
        }

        if ($error == null) {
            $s = "INSERT INTO `rooms`(`room`, `image`, `price`, `status`) VALUES ('$name','$image', '$price',0)";
            $result = $conn->query($s);
            if ($result) {
                header("Location: index-room.php");
            }
        } else {
            $_SESSION['err'] = $error;
            return header("Location: create-room.php");
        }
    } else {
        die('loi');
    }
}
function checkRoomExists($conn, $name)
{
    $sql = "SELECT * FROM rooms WHERE room = '$name'";
    $qr = $conn->query($sql);
    if ($qr->num_rows > 0) {
        return $qr->fetch_assoc();
    }
}
function booking($conn)
{
    if (isset($_POST['checkin']) && isset($_POST['checkout'])) {
        $id_account = $_SESSION['all']['id_account'];
        $id_room = $_POST['id_room'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $s = "INSERT INTO bookings(checkin, checkout, status, id_account, id_room) VALUES ('$checkin', '$checkout', 1, '$id_account','$id_room')";
        $result = $conn->query($s);
        // var_dump($result);
        // exit;
        if ($result) {
            $conn->query("UPDATE rooms SET status = 1 WHERE id = '$id_room'");
            header("Location: ../booking/mypage.php");
        } else {
            die('Check k ton tai');
        }
    } else {
        die('Check k ton tai');
    }
}

function getNameOfRoom($conn, $id_room)
{
    $sql = "SELECT room FROM `rooms` WHERE id = '$id_room'";
    $qr = $conn->query($sql);
    if ($qr->num_rows > 0) {
        return $qr->fetch_assoc();
    }
}

function getNameOfUser($conn, $id_user)
{
    $sql = "SELECT username FROM `accounts` WHERE id_account = '$id_user'";
    $qr = $conn->query($sql);
    if ($qr->num_rows > 0) {
        return $qr->fetch_assoc();
    }
}


function getOnAdmin($conn)
{
    $sql = "SELECT COUNT(id_account) as 'soluong' FROM accounts WHERE role = 1";
    $qr = $conn->query($sql);
    if ($qr->num_rows > 0) {
        return $qr->fetch_assoc();
    }
}

function getOnStaff($conn)
{
    $sql = "SELECT COUNT(id_account) as 'soluong' FROM accounts WHERE role = 2";
    $qr = $conn->query($sql);
    if ($qr->num_rows > 0) {
        return $qr->fetch_assoc();
    }
}

function getOnUser($conn)
{
    $sql = "SELECT COUNT(id_account) as 'soluong' FROM accounts WHERE role = 3";
    $qr = $conn->query($sql);
    if ($qr->num_rows > 0) {
        return $qr->fetch_assoc();
    }
}

function showUserBooking($conn)
{

    $id_user = $_SESSION['id'];
    // var_dump($id_user);
    // exit;
    $s = "SELECT * FROM bookings WHERE id_account = '$id_user' ORDER BY id";
    $qr = $conn->query($s);
    $str = '';
    while ($r = $qr->fetch_assoc()) {
        $str .= '<tr>
        <th>' . getNameOfRoom($conn, $r['id_room'])['room'] . '</th>
        <th>' . getNameOfUser($conn, $r['id_account'])['username'] . '</th>
        <th>' . $r['checkin'] . '</th>
        <th>' . $r['checkout'] . '</th>
        <th><a href="update-status-of-room.php?id_room=' . $r['id_room'] . '">Cancel</a></th>
        </tr>';
    }
    echo $str;
}

function deleteBooking($conn, $id)
{
    $sql = "DELETE FROM `bookings` WHERE id_room = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php");
    }
}

function adminDeleteBooking($conn, $id)
{
    $sql = "DELETE FROM `bookings` WHERE id_room = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: booking.php");
    }
}

function updateStatusOfRoom($conn, $id_room)
{
    $s = "UPDATE rooms SET status = 0 WHERE id = '$id_room'";
    if ($conn->query($s) === TRUE) {
        return TRUE;
    }
}

function updateRoom($conn)
{
    if (isset($_GET['name']) && isset($_GET['image']) && isset($_GET['price']) && isset($_GET['status']) && isset($_GET['id'])) {
        $id = $_GET['id'];
        $name = $_GET['name'];
        $image = $_GET['image'];
        $price = $_GET['price'];
        $status = $_GET['status'];
        $s = "UPDATE rooms SET room = '$name', image = '$image', price = '$price', status = '$status' WHERE id = $id";
        $qr = $conn->query($s);
        if ($qr) {
            header("Location: index-room.php");
        }
    }
}

function deleteRoom($conn)
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $s = "DELETE FROM rooms WHERE id = $id";
        $qr = $conn->query($s);
        if ($qr) {
            header("Location: index-room.php");
        }
    }
}

function getAccount($conn)
{
    $s = "SELECT * FROM accounts";
    $qr = $conn->query($s);
    $str = '';
    $role = '';
    $del = '';
    while ($r = $qr->fetch_assoc()) {
        if ($r['role'] == 1) {
            $role = 'Admin';
            $del = '';
        } else if ($r['role'] == 2) {
            $role = 'Staff';
            $del = '<a href="delete-account.php?id=' . $r['id_account'] . '">Delete</a>';
        } else {
            $role = 'User';
            $del = '<a href="delete-account.php?id=' . $r['id_account'] . '">Delete</a>';
        }
        $str .= '<tr>
        <th>' . $r['username'] . '</th>
        <th>' . $r['email'] . '</th>
        <th>' . $r['phone'] . '</th>
        <th>' . $role . '</th>
        <th>' . $del . '</th>
        </tr>';
    }
    echo $str;
}

function deleteAccount($conn)
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM accounts WHERE id_account = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: index-account.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        die('loi');
    }
}

function showBooking($conn)
{
    $s = "SELECT * FROM bookings ORDER BY id";
    $qr = $conn->query($s);
    $str = '';
    while ($r = $qr->fetch_assoc()) {
        $str .= '<tr>
        <th>' . getNameOfRoom($conn, $r['id_room'])['room'] . '</th>
        <th>' . getNameOfUser($conn, $r['id_account'])['username'] . '</th>
        <th>' . $r['checkin'] . '</th>
        <th>' . $r['checkout'] . '</th>
        <th><a href="update-status-of-room.php?id_room=' . $r['id_room'] . '">Cancel</a></th>
        </tr>';
    }
    echo $str;
}
