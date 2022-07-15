<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
include '../conn.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $s = "SELECT * from rooms where id = $id";
    $qr = $conn->query($s);
    $status = '';
    $r = $qr->fetch_assoc();
    if ($r['status'] == 0) {
        $status = 'Phòng trống';
    } else {
        $status = 'Đã đặt';
    }
}
?>
<div class="container">
    <h2>Chi tiết phòng</h2>
    <a href="index-room.php" class="btn btn-danger" style="margin-left: 1235px;">Back</a>
    <div class="form-group">
        <label for="name">Tên Phòng</label>
        <input type="text" class="form-control" value="<?php echo $r['room'] ?>" name="room" id="" disabled>
    </div>
    <div class="form-group">
        <label for="name">Giá Phòng</label>
        <input type="text" class="form-control" value="<?php echo $r['price']; ?>" name="price" id="" disabled>
    </div>
    <div class="form-group">
        <label for="name">Tình trạng</label>
        <input type="text" class="form-control" value="<?php echo $status; ?>" name="status" id="" disabled>
    </div>
    <div class="form-group">
        <label for="name">Hình ảnh</label><br>
        <img src="../images/<?php echo $r['image'] ?>" alt="" srcset="" width="650" ">
    </div>
</div>