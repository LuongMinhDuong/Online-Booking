<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="container" style="margin-left:20px;margin-bottom:304px">
    <?php
    if (!isset($_SESSION['user'])) {
        echo '<h1>TRANG CHỦ</h1>';
        echo '<a href="./login/form.php" class="btn btn-primary">Login</a>
                <a href="./register/form.php" class="btn btn-success">Register</a>';
    }
    if (isset($_SESSION['user'])) {
        echo '<h1>My Page</h1>';
        echo '<h5>Xin chào, ' . $_SESSION['user']['username'] . ' |<a href="./login/logout.php"> Đăng xuất khỏi Trái Đất</a>' . '</h5>';
        echo '<h5>Thông tin cá nhân của bạn</h5>' .
            '<table style: border="1">' .
            '<tr>' .
            '<th>Họ và tên</th>' .
            '<th>Email</th>' .
            '<th>Số điện thoại</th>' .
            '</tr>' .
            '<tr>' .
            '<td>' . $_SESSION['user']['username'] . '</td>' .
            '<td>' . $_SESSION['user']['email'] . '</td>' .
            '<td>' . $_SESSION['user']['phone'] . '</td>' .
            '</tr>' .

            '</table>';
    }


    ?>



</div>