<?php
include('./conn.php');

if (isset($_SESSION['user']['role']) == 3) {
    echo 'Xin chào!, ' . $_SESSION['user']['username'] . ' |<a href="./login/logout.php"> Đăng xuất</a>' . '</h5>';
}
if (isset($_SESSION['id']) == false) {
    $disabled2 = 'disabled';
} else {
    $disabled2 = '';
}

$s = "SELECT * FROM rooms";
$qr = $conn->query($s);
?>
<div class="list-room">

    <?php
    while ($r = $qr->fetch_assoc()) {
        if ($r['status'] == 1) {
            $class = 'booking';
            $disabled = 'disabled';
        } else {
            $class = '';
            $disabled = '';
        }
    ?>
        <div class="room-item <?php echo $class; ?>">
            <h3 class="name">Phòng: <?= $r['room'] ?></h3>
            <h4 class="price">Giá: <?= $r['price'] . '$' ?></h4>
            Trạng thái:
            <a href="booking/booking.php?id=<?= $r['id'] ?>" class="btn btn-primary <?= $disabled ?> <?= $disabled2 ?>">Booking</a>
        </div>
    <?php
    }
    ?>
</div>