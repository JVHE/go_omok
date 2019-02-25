<body>
<?php require("util/navbar.php"); ?>


<?php
$nickname = $_SESSION['nickname'];
$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game') or die("DB 연결에 실패하였습니다.");
$sql = "SELECT * FROM user WHERE nickname='" . $nickname . "';";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$user_id = $row['id'];


?>
<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<style>

    /* Profile container */
    .profile {
        margin: 20px 0;
    }

    /* Profile sidebar */
    .profile-sidebar {
        padding: 20px 0 10px 0;
        background: #fff;
        text-align: center;
    }

    .profile-userpic img {
        float: none;
        margin: auto;
        max-width: 200px;
        width: 50%;

        height: auto;
        -webkit-border-radius: 50% !important;
        -moz-border-radius: 50% !important;
        border-radius: 50% !important;
    }

    .profile-usertitle {
        text-align: center;
        margin-top: 20px;
    }

    .profile-usertitle-name {
        color: #5a7391;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .profile-usertitle-job {
        text-transform: uppercase;
        color: #5b9bd1;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .profile-userbuttons {
        text-align: center;
        margin-top: 10px;
    }

    .profile-userbuttons .btn {
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 600;
        padding: 6px 15px;
        margin-right: 5px;
    }

    .profile-userbuttons .btn:last-child {
        margin-right: 0px;
    }

    .profile-usermenu {
        margin-top: 30px;
    }

    .profile-usermenu ul li {
        border-bottom: 1px solid #f0f4f7;
    }

    .profile-usermenu ul li:last-child {
        border-bottom: none;
    }

    .profile-usermenu ul li a {
        color: #93a3b5;
        font-size: 14px;
        font-weight: 400;
    }

    .profile-usermenu ul li a i {
        margin-right: 8px;
        font-size: 14px;
    }

    .profile-usermenu ul li a:hover {
        background-color: #fafcfd;
        color: #5b9bd1;
    }

    .profile-usermenu ul li.active {
        border-bottom: none;
    }

    .profile-usermenu ul li.active a {
        color: #5b9bd1;
        background-color: #f6f9fb;
        border-left: 2px solid #5b9bd1;
        margin-left: -2px;
    }

    /* Profile Content */
    .profile-content {
        padding: 20px;
        background: #3e667a;
        min-height: 460px;
    }
</style>

<div class="container-fluid col-10">
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="<?php echo ($row['link_profile'] != null) ? $row['link_profile'] : "images/default_profile.png"; ?>"
                         class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $row['nickname']; ?>
                    </div>
                    <div class="profile-usertitle-job">
                        티어
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    <?php
                    if ($nickname == $_SESSION['nickname']) {
                        ?>
                        <!--                        <a class="btn-primary" href="user_edit_password_check.php" role="button">회원정보 수정</a>-->
                        <!--                        <a class="btn-info" href="user_edit_password_check.php" role="button">친구 목록 관리</a>-->

                        <button type="button" class="btn btn-primary"
                                onclick="location.href='user_edit_password_check.php'">회원정보 수정
                        </button>
                        <button type="button" class="btn btn-info">친구 목록 관리</button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-success">친구 맺기</button>
                        <button type="button" class="btn btn-secondary">메세지</button>
                        <button type="button" class="btn btn-danger">차단</button>
                        <?php
                    }
                    ?>
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <!--                <div class="profile-usermenu">-->
                <!--                    <ul class="nav">-->
                <!--                        <li class="active">-->
                <!--                            <a href="#">-->
                <!--                                <i class="glyphicon glyphicon-home"></i>-->
                <!--                                Overview </a>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#">-->
                <!--                                <i class="glyphicon glyphicon-user"></i>-->
                <!--                                Account Settings </a>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#" target="_blank">-->
                <!--                                <i class="glyphicon glyphicon-ok"></i>-->
                <!--                                Tasks </a>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#">-->
                <!--                                <i class="glyphicon glyphicon-flag"></i>-->
                <!--                                Help </a>-->
                <!--                        </li>-->
                <!--                    </ul>-->
                <!--                </div>-->
                <!-- END MENU -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="profile-content">
                <img src="images/example.jpg" style="width: 512px; height: 512px;">
            </div>
        </div>
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="<?php echo ($row['link_profile'] != null) ? $row['link_profile'] : "images/default_profile.png"; ?>"
                         class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $row['nickname']; ?>
                    </div>
                    <div class="profile-usertitle-job">
                        티어
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    <?php
                    if ($nickname == $_SESSION['nickname']) {
                        ?>
                        <!--                        <a class="btn-primary" href="user_edit_password_check.php" role="button">회원정보 수정</a>-->
                        <!--                        <a class="btn-info" href="user_edit_password_check.php" role="button">친구 목록 관리</a>-->

                        <button type="button" class="btn btn-primary"
                                onclick="location.href='user_edit_password_check.php'">회원정보 수정
                        </button>
                        <button type="button" class="btn btn-info">친구 목록 관리</button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-success">친구 맺기</button>
                        <button type="button" class="btn btn-secondary">메세지</button>
                        <button type="button" class="btn btn-danger">차단</button>
                        <?php
                    }
                    ?>
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <!--                <div class="profile-usermenu">-->
                <!--                    <ul class="nav">-->
                <!--                        <li class="active">-->
                <!--                            <a href="#">-->
                <!--                                <i class="glyphicon glyphicon-home"></i>-->
                <!--                                Overview </a>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#">-->
                <!--                                <i class="glyphicon glyphicon-user"></i>-->
                <!--                                Account Settings </a>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#" target="_blank">-->
                <!--                                <i class="glyphicon glyphicon-ok"></i>-->
                <!--                                Tasks </a>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#">-->
                <!--                                <i class="glyphicon glyphicon-flag"></i>-->
                <!--                                Help </a>-->
                <!--                        </li>-->
                <!--                    </ul>-->
                <!--                </div>-->
                <!-- END MENU -->
            </div>
        </div>
    </div>
</div>
</body>