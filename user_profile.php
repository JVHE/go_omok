<body>
<?php require("util/navbar.php"); ?>
<?php
$nickname = $_GET['nickname'];
$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game') or die("DB 연결에 실패하였습니다.");
$sql = "SELECT * FROM user WHERE nickname='" . $nickname . "';";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$user_id = $row['id'];
if ($row == null) {
    echo "<meta http-equiv='refresh' content='0;url=/main.php'>";
}

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
        <div class="col-md-9">
            <div class="profile-content">
                <table class="table">
                    <thead>
                    <h3 style="color: #05293a;">종합 전적</h3>
                    <tr class="table-dark">
                        <th>종목</th>
                        <th>전적</th>
                        <th>승률</th>
                        <th>최근 플레이 날짜</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--                    <tr class="table-dark">-->
                    <!--                        <td>--><?php
                    //                            echo "총합";
                    //                            ?><!--</td>-->
                    <!--                        <td>--><?php
                    //                            echo (($row['play_times'] == '') ? 0 : $row['play_times']) . "전 " . (($row['win'] == '') ? 0 : $row['win']) . "승 " . (($row['lose'] == '') ? 0 : $row['lose']) . "패 " . (($row['draw'] == '') ? 0 : $row['draw']) . "무 ";
                    //                            ?><!--</td>-->
                    <!--                        <td>-->
                    <!--                            <div class="progress ">-->
                    <!--                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"-->
                    <!--                                     aria-valuemin="0" aria-valuemax="100"></div>-->
                    <!--                            </div>-->
                    <!--                            --><?php
                    //                            if ($row['play_times'] != 0) {
                    //                                $percent = $row['win'] * 100 / $row['play_times'];
                    //                                echo $percent . "%";
                    //                            }
                    //                            ?>
                    <!--                            25%-->
                    <!--                        </td>-->
                    <!--                        <td>2018년 7월 10일</td>-->
                    <!--                    </tr>-->
<!--                    <tr class="table-dark">-->
<!--                        <td>--><?php
//                            echo "총합";
//                            ?><!--</td>-->
<!--                        <td>--><?php
//                            //                            echo (($row['play_times'] == '') ? 0 : $row['play_times']) . "전 " . (($row['win'] == '') ? 0 : $row['win']) . "승 " . (($row['lose'] == '') ? 0 : $row['lose']) . "패 " . (($row['draw'] == '') ? 0 : $row['draw']) . "무 ";
//                            ?>
<!--                            640전 330승 304패 6무-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <div class="progress">-->
<!--                                <div class="progress-bar col-6" role="progressbar" style="width: 50%;"-->
<!--                                     aria-valuenow="52"-->
<!--                                     aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                                <b style="color: red">52%</b>-->
<!--                            </div>-->
<!--                            --><?php
//                            if ($row['play_times'] != 0) {
//                                $percent = $row['win'] * 100 / $row['play_times'];
//                                echo $percent . "%";
//                            }
//                            ?>
<!--                        </td>-->
<!--                        <td>2018년 7월 10일</td>-->
<!--                    </tr>-->
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?php
                            //                            echo (($row['play_times'] == '') ? 0 : $row['play_times']) . "전 " . (($row['win'] == '') ? 0 : $row['win']) . "승 " . (($row['lose'] == '') ? 0 : $row['lose']) . "패 " . (($row['draw'] == '') ? 0 : $row['draw']) . "무 ";
                            ?>
                            201전 101승 100패 0무
                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar col-6" role="progressbar" style="width: 50%;"
                                     aria-valuenow="50"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                                <b style="color: red">50%</b>
                            </div>
                            <?php
                            if ($row['play_times'] != 0) {
                                $percent = $row['win'] * 100 / $row['play_times'];
                                echo $percent . "%";
                            }
                            ?>
                        </td>
                        <td>2019년 1월 6일</td>
                    </tr>
<!--                    <tr class="table-dark">-->
<!--                        <td>--><?php
//                            echo "체스";
//                            ?><!--</td>-->
<!--                        <td>--><?php
//                            //                            echo (($row['play_times'] == '') ? 0 : $row['play_times']) . "전 " . (($row['win'] == '') ? 0 : $row['win']) . "승 " . (($row['lose'] == '') ? 0 : $row['lose']) . "패 " . (($row['draw'] == '') ? 0 : $row['draw']) . "무 ";
//                            ?>
<!--                            337전 160승 175패 2무-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <div class="progress">-->
<!--                                <div class="progress-bar col-6" role="progressbar" style="width: 50%;"-->
<!--                                     aria-valuenow="47"-->
<!--                                     aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                                <b style="color: red">47%</b>-->
<!--                            </div>--><?php
//                            if ($row['play_times'] != 0) {
//                                $percent = $row['win'] * 100 / $row['play_times'];
//                                echo $percent . "%";
//                            }
//                            ?><!--</td>-->
<!--                        <td>2018년 7월 10일</td>-->
<!--                    </tr>-->
<!--                    <tr class="table-dark">-->
<!--                        <td>--><?php
//                            echo "배틀쉽";
//                            ?><!--</td>-->
<!--                        <td>--><?php
//                            //                            echo (($row['play_times'] == '') ? 0 : $row['play_times']) . "전 " . (($row['win'] == '') ? 0 : $row['win']) . "승 " . (($row['lose'] == '') ? 0 : $row['lose']) . "패 " . (($row['draw'] == '') ? 0 : $row['draw']) . "무 ";
//                            ?>
<!--                            93전 67승 26패 0무-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <div class="progress">-->
<!--                                <div class="progress-bar col-6" role="progressbar" style="width: 72%;"-->
<!--                                     aria-valuenow="36"-->
<!--                                     aria-valuemin="0" aria-valuemax="50"></div>-->
<!--                                <b style="color: red">72%</b>-->
<!--                            </div>--><?php
//                            if ($row['play_times'] != 0) {
//                                $percent = $row['win'] * 100 / $row['play_times'];
//                                echo $percent . "%";
//                            }
//                            ?><!--</td>-->
<!--                        <td>2018년 7월 10일</td>-->
<!--                    </tr>-->
                    </tbody>
                </table>

                <table class="table">
                    <thead>
                    <h3 style="color: #05293a;">최근 전적</h3>
                    <tr class="table-dark">
                        <th>종목</th>
                        <th>결과</th>
                        <th>상대방</th>
                        <th>최근 플레이 날짜</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "승";
                            ?></td>
                        <td><?= "구구";
                            ?></td>
                        <td>2019년 1월 6일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "패";
                            ?></td>
                        <td><?= "체크";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "승";
                            ?></td>
                        <td><?= "테스트";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "승";
                            ?></td>
                        <td><?= "테스트";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "승";
                            ?></td>
                        <td><?= "테스트";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "패";
                            ?></td>
                        <td><?= "테스트";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "패";
                            ?></td>
                        <td><?= "이정배123";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "패";
                            ?></td>
                        <td><?= "테스트";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "승";
                            ?></td>
                        <td><?= "카카루";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    <tr class="table-dark">
                        <td><?php
                            echo "오목";
                            ?></td>
                        <td><?= "승";
                            ?></td>
                        <td><?= "티티";
                            ?></td>
                        <td>2018년 7월 9일</td>
                    </tr>
                    </tbody>
                </table>

                <div style="text-align: center;">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">&laquo;</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">5</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">6</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">7</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">8</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">9</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">10</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
