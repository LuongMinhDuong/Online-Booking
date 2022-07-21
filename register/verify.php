
<?php
include('../conn.php');
date_default_timezone_set("Asia/Ho_Chi_Minh");
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $packToken = pack('H*', $token);

    $data = explode('_', $packToken);
    $endDate = strtotime($data[1]) + 86400;

    $now = strtotime(date('d-m-Y H:i:s'));
    var_dump($endDate - $now);

    if ($endDate - $now <= 0) {
        echo '<div class="text-center">
        <div class="error mx-auto" data-text="404">404</div>
        <p class="lead text-gray-800 mb-5">Page Not Found</p>
        <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
        <a href="form.html">&larr; Back to Login</a>
    </div>';
    } else {
        $sql = "UPDATE accounts SET user_status = 1 WHERE id_account = '$data[0]'";
        $result = $conn->query($sql);
        Header('Location: ../login/form.php');
    }
}
?>