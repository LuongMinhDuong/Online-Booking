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
            $del = '';
        } else {
            $status = 'Đã đặt';
            $del = '<a href="delete-room.php?id=' . $r['id'] . '">Delete</a>';
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
