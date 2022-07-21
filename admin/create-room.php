<?php include("../conn.php");
include("function.php");
session_start();
?>
<?php
include("header.php");
?>
<div class="form-tt">
    <style>
        body {
            padding: 50px;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .form-tt {
            width: 1150px;
            border-radius: 10px;
            overflow: hidden;
            padding: 55px 55px 37px;
            background: #9152f8;
            background: -webkit-linear-gradient(top, #7579ff, #b224ef);
            background: -o-linear-gradient(top, #7579ff, #b224ef);
            background: -moz-linear-gradient(top, #7579ff, #b224ef);
            background: linear-gradient(top, #7579ff, #b224ef);
            text-align: center;
            margin-left: 50px;
        }

        .form-tt h2 {
            font-size: 30px;
            color: #fff;
            line-height: 1.2;
            text-align: center;
            text-transform: uppercase;
            display: block;
            margin-bottom: 30px;
        }

        .form-tt input[type=text],
        .form-tt input[type=password] {
            font-family: Poppins-Regular;
            font-size: 16px;
            color: #fff;
            line-height: 1.2;
            display: block;
            width: calc(100% - 10px);
            height: 45px;
            background: 0 0;
            padding: 10px 0;
            border-bottom: 2px solid rgba(255, 255, 255, .24) !important;
            border: 0;
            outline: 0;
        }

        .form-tt input[type=text]::focus,
        .form-tt input[type=password]::focus {
            color: red;
        }

        .form-tt input[type=password] {
            margin-bottom: 20px;
        }

        .form-tt input::placeholder {
            color: #fff;
        }

        .checkbox {
            display: block;
        }

        .form-tt input[type=submit] {
            font-size: 16px;
            color: #555;
            line-height: 1.2;
            padding: 0 20px;
            min-width: 120px;
            height: 50px;
            border-radius: 25px;
            background: #fff;
            position: relative;
            z-index: 1;
            border: 0;
            outline: 0;
            display: block;
            margin: 30px auto;
        }

        #checkbox {
            display: inline-block;
            margin-right: 10px;
        }

        .checkbox-text {
            color: #fff;
        }

        .psw-text {
            color: #fff;
        }
    </style>
    </style>
    <h2>Thêm mới phòng</h2>
    <?php
    // var_dump($_SESSION['err']);
    ?>
    <form action="add-room.php" method="post" enctype="multipart/>">
        <div>
            <input type="text" name="ten" placeholder="Nhập tên phòng" />
            <span class="error"> <?= (isset($_SESSION['err']['name']) ? $_SESSION['err']['name'] :  '') ?></span>
        </div>
        <label for="" style="color: white; margin-right:965px; margin-top:10px">
            <input type="file" name="anh" />
        </label>
        <div>
            <input type="text" name="gia" placeholder="Nhập giá" />
            <span class="error"> <?= (isset($_SESSION['err']['price']) ? $_SESSION['err']['price'] :  '') ?></span>
        </div>
        <input type="submit" name="submit" value="Add" />
    </form>
</div>
<?php
include("footer.php");
?>