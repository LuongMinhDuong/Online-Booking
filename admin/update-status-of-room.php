<?php
include("../conn.php");
include("function.php");
if (isset($_GET['id_room'])) {
    $id_room = $_GET['id_room'];
    if (updateStatusOfRoom($conn, $id_room)) {
        adminDeleteBooking($conn, $id_room);
    }
} else {
    die('Phòng không tồn tại');
}
