<?php
include '../conn.php';

function getRoom($conn)
{
    $s = "SELECT * FROM rooms";
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

function addRoom($conn)
{
    if (isset($_GET['ten']) && isset($_GET['anh']) && isset($_GET['gia']) && isset($_GET['tinhtrang'])) {
        $name = $_GET['ten'];
        $image = $_GET['anh'];
        $price = $_GET['gia'];
        $status = $_GET['tinhtrang'];
        $s = "INSERT INTO rooms VALUES (NULL, '$name', '$image', '$price', '$status')";
        $result = $conn->query($s);
        if ($result) {
            header("Location: index-room.php");
        }
    }
}

function booking($conn)
{
    if (isset($_POST['checkin']) && isset($_POST['checkout'])) {
        $id_account = $_POST['id_account'];
        $id_room = $_POST['id_room'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $s = "INSERT INTO bookings(checkin, checkout, status, id_account, id_room) VALUES ('$checkin', '$checkout', 1, '$id_account','$id_room')";
        $result = $conn->query($s);
        if ($result) {
            $conn->query("UPDATE rooms SET status = 1 WHERE id = '$id_room'");
            header("Location: mypage.php");
        }
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

function showBooking($conn)
{

    $id_user = $_SESSION['id'];
    // var_dump($id_user);
    // exit;
    $s = "SELECT * FROM bookings WHERE id_account = '$id_user'";
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

function searchRoom($conn)
{
}
