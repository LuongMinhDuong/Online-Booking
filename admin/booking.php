<?php
include 'header.php';
include('../conn.php');
?>
<h1>Booking</h1>
<label for="meeting-time">Checkin</label>&ensp;
<input type="datetime-local" id="checkin" name="meeting-time" value="" min="" max=""><br>
<hr>
<label for="meeting-time">Checkout</label>
<input type="datetime-local" id="checkout" name="meeting-time" value="" min="" max="">


<?php
include 'footer.php';
// function get_name_acccount()
// {
//     $sql = "SELECT c.* FROM bookings b JOIN accounts c ON b.id_account = c.id_account";
// }
// function get_name_room()
// {
//     $sql = "SELECT r.* FROM bookings b JOIN rooms r ON b.id_room = r.id";
// }
?>