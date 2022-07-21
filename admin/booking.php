<?php
include 'header.php';
include('../conn.php');

// if (isset($_POST['checkin']) && isset($_POST['checkout']) && isset($_POST['booking'])) {
//     $checkin = $_POST['checkin'];
//     $checkout = $_POST['checkout'];
//     $s = "INSERT INTO bookings VALUES ('', '$checkin', '$checkout', '', '','')";
//     $result = $conn->query($s);
//     if ($result) {
//         echo '<script>alert("Booking thành công!")</script>';
//         header("Location: ./index.php");
//     }
// }

if (isset($_GET['id'])) {
    $id_room = $_GET['id'];
}
if ($_SESSION['id'] == true) {
    $id_account = $_SESSION['id'];
}
?>
<div class="container" style="text-align: center">
    <h1>Booking</h1>
    <form action="create-booking.php" method="post">
        <label for="meeting-time">Checkin:</label>&ensp;
        <input type="datetime-local" id="checkin" name="checkin" value="" min="" max=""><br>
        <input type="hidden" id="" name="id_account" value="<?= $id_account ?>" />
        <hr>
        <label for="meeting-time">Checkout:</label>
        <input type="datetime-local" id="checkout" name="checkout" value="" min="" max=""><br>
        <hr>
        <input type="hidden" id="" name="id_room" value="<?= $id_room ?>" />
        <button type="submit" name="booking">Booking</button>
    </form>
</div>

<?php
include 'footer.php';
?>