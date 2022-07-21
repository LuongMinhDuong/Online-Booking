<?php
include 'header.php';
include '../conn.php';
include 'function.php';


$role = $_SESSION['user'];

$checkLogin = $_SESSION['check_login'];


?>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        var admin = <?= getOnAdmin($conn)['soluong']; ?>;
        var staff = <?= getOnStaff($conn)['soluong']; ?>;
        var user = <?= getOnUser($conn)['soluong']; ?>;
    </script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Vai trò', 'Số lượng'],
                ['Admin', admin],
                ['Staff', staff],
                ['User', user],
            ]);

            var options = {
                title: 'Thống kê tài khoản',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
</body>

</html>

<?php
include 'footer.php';
?>