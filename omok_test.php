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
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>

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

    .oboard {
        width: 500px;
        margin: 0 auto;
        background-color: #ffc078;
    }

    .orow {
        display: flex;
    }

    .ocol {
        position: relative;
        flex-grow: 1;
        cursor: pointer;
    }

    .ocol:hover {
        background-color: #fd7e14;
    }

    .ocol::before {
        display: block;
        content: '';
        padding-bottom: 100%;
    }

    .ocol::after {
        position: absolute;
        display: block;
        content: '';
        padding-bottom: 80%;
        width: 80%;
        top: 10%;
        left: 10%;
        border-radius: 50%;
    }

    .ocol.black::after {
        background-color: black;
    }

    .ocol.white::after {
        background-color: white;
    }

    .ocol__grid {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .ocol__grid::after {
        display: block;
        content: '';
        position: absolute;
        top: 0;
        right: calc(50% - 1px);
        bottom: calc(50% - 1px);
        left: 0;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        box-sizing: border-box;
    }

    .ocol__grid::before {
        display: block;
        content: '';
        position: absolute;
        top: calc(50%);
        right: -1px;
        bottom: -1px;
        left: calc(50%);
        border-top: 1px solid black;
        border-left: 1px solid black;
        box-sizing: border-box;
    }

    .orow:first-child .ocol__grid::after {
        border-top: none;
        border-left: none;
        border-right: none;
    }

    .orow:last-child .ocol__grid::before {
        border-bottom: none;
        border-left: none;
        border-right: none;
    }

    .ocol:first-child .ocol__grid::after {
        border-top: none;
        border-left: none;
        border-bottom: none;
    }

    .ocol:last-child .ocol__grid::before {
        border-top: none;
        border-bottom: none;
        border-right: none;
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
            <div class="oboard" id="oboard">
                <?php
                for ($i = 1;
                     $i <= 15;
                     $i++) {
                    ?>
                    <div class="orow-<?= $i; ?> orow">
                        <?php
                        for ($j = 1;
                             $j <= 15;
                             $j++) {
                            ?>

                            <!--                            onclick="alert('행: --><?//= $i; ?><!-- 열: --><?//= $j; ?><!--'+id)"-->
                            <div class="ocol-<?= $j; ?> ocol" id="r<?= $i; ?>c<?= $j; ?>"
                                 onclick="stoneClick(<?= $i; ?> , <?= $j; ?>)" value="0">
                                <!--                                 onclick="fclick()">-->
                                <div class="ocol__grid"></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <!--                <img src="images/example.jpg" style="width: 100%; max-width: 512px; height: 100%; max-height: 512px;">-->
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
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-primary" onclick="loadURL()">로드</button>
<h1 id="hcheck" class="hcheck">2222</h1>
<form method="post" action="omok_test_result.php" hidden>
    <label for="is_white"></label>
    <input id="is_white" name="is_white" hidden value="true">
</form>
</body>


<script language="Jscript">
    // function fclick() {
    //     alert("111");
    //     // document.getElementById("hcheck").value = "111";
    // }

    // var socket= io.connect("http://192.168.122.138:8888");
    var socket = io("http://192.168.122.138:8888/");


    var color = 'black';

    function stoneClick(row, col) {


        var id2 = "r" + row + "c" + col;

        if (document.getElementById(id2).getAttribute('value') === "0") {
            // $('#hcheck').html("빈칸누름");
            socket.emit("stoneIn", {
                uid: <?=$_SESSION['id'];?>,
                name: "<?=$_SESSION['nickname'];?>",
                room: -1,
                color: color,
                row: row,
                col: col
            });

            (color === 'black') ? color = 'white' : color = 'black';
        }
    }

    socket.on("stoneOut", function (data) {
        var id = "#r" + data.row + "c" + data.col;
        var id2 = "r" + data.row + "c" + data.col;
        // a가 1, 흰돌 두기
        // a가 2, 검은돌 두기
        // a가 10, 흰 승
        // a가 20, 검 승
        $(id).removeClass("ocol-" + data.col + " ocol").addClass("ocol-" + data.col + " ocol " + data.color);
        document.getElementById(id2).setAttribute('value', data.state);
        $('#hcheck').html(data.name + "가 " + data.room + "번 방에서 " + data.color + "돌을 (" + data.row + ", " + data.col + ")자리에 두었다.<br>다음은 " + ((data.color === 'black') ? 'white' : 'black') + " 차례입니다.");
        if (data.name === "<?=$_SESSION['nickname'];?>") {
            document.getElementById("oboard").style.pointerEvents = "none";
        } else {
            document.getElementById("oboard").style.pointerEvents = "auto";
        }
        // alert(data);
    });


</script>
<?php
$sql = "SELECT * FROM omok_record";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    $id = "#r" . $row['row'] . "c" . $row['col'];
    echo "<script>$('"
        . $id .
        "').removeClass('ocol-"
        . $row['col'] .
        " ocol').addClass('ocol-"
        . $row['col'] .
        " ocol "
        . $row['color'] .
        "');</script>";
}
echo session_save_path();
?>


