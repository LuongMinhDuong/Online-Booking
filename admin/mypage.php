<?php
include 'header.php';
include('../conn.php');
include("function.php");
?>

<table class="styled-table">
    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 60px;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 1150px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);

        }

        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
    </style>
    <thead>
        <tr>
            <th>Tên phòng</th>
            <th>Người đặt</th>
            <th>Checkin</th>
            <th>Check out</th>
            <th>Hành Động</th>
        </tr>
    </thead>

    <?php showBooking($conn); ?>
</table>
<a href="../index.php" class="btn btn-danger" style="margin-left:60px">Về trang chủ</a>
<?php
include 'footer.php';
?>