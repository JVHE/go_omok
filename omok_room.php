<body>
<?php require("util/navbar.php"); ?>
<?php
$nickname = $_SESSION['nickname'];
$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game') or die("DB 연결에 실패하였습니다." . mysqli_error($conn));
$sql = "SELECT * FROM user WHERE nickname='" . $nickname . "';";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$user_id = $row['id'];
?>
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

<?php
$is_make = $_POST['is_make'];

// 만약 $_POST['room_id']가 ''라면 방을 생성하고 post의 값이 존재한다면 방에 입장한다는 뜻이다.
if ($is_make == 'true') {
    $sql = "SELECT COUNT(*) FROM room";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
//    echo "<script>alert($room_id)</script>";
    // 방을 새로 만들었으니 방장이 되고 id는 룸 갯수+1로 설정.
    // node 서버에 방이 만들어졌다고 보낸다.
    $title = $_POST['title'];
    $id = $_SESSION['id'];
    $password = $_POST['password'];
    $is_public = ($password == '') ? 1 : 0;
    $sql = "INSERT INTO room VALUES (null, '$title', $id, -1, $is_public, '$password')";
//    echo $sql;
    mysqli_query($conn, $sql) or die("DB 연결에 실패하였습니다." . mysqli_error($conn));
    $sql = "SELECT room_id FROM room ORDER BY room_id DESC LIMIT 1;";
//    echo $sql;
    $result = mysqli_query($conn, $sql) or die("DB 연결에 실패하였습니다.");
    $row = mysqli_fetch_array($result);
    $room_id = $row['room_id'];
} else {
    // 방 입장
    $room_id = $_GET['room_id'];
    $password = $_POST['password'];
    $is_public = ($password == '') ? 1 : 0;

    $sql = "SELECT * FROM room WHERE room_id = $room_id";
    $result = mysqli_query($conn, $sql) or die("DB 연결에 실패하였습니다.");
    $row = mysqli_fetch_array($result);
    if ($row['is_public'] == 0 && $password != $row['password']) {
        echo "<script>alert('비밀번호가 틀렸습니다 . 이전 페이지로 돌아갑니다.');document.location='omok_waiting_room.php';</script>";
    }
    if ($room_id == '') {
        echo "<script>document.location='omok_waiting_room.php';</script>";
    }
    $title = $row['title'];
    $id = $_SESSION['id'];
    $sql = "UPDATE room SET opponent_id = $id WHERE room_id = $room_id";
    mysqli_query($conn, $sql) or die("DB 연결에 실패하였습니다.");

}

?>


<div class="container-fluid col-10">
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="<?php echo ($_SESSION['link_profile'] != null) ? $_SESSION['link_profile'] : "images/default_profile.png"; ?>"
                         class="img-responsive" alt="" style="background-color:#b6f1ff;">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $_SESSION['nickname']; ?>
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
            <br>
            <button type="button" class="btn btn-success btn-lg btn-block" id="btn_ready" value="waiting"
                    onclick="ready()">레디
            </button>
        </div>
        <div class="col-md-6">
            <div class="oboard" id="oboard" style="pointer-events: none">
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
                <div class="profile-userpic" id="pic2">
                    <!--                    <img src="-->
                    <?php //echo ($row['link_profile'] != null) ? $row['link_profile'] : "images/default_profile.png"; ?><!--"-->
                    <!--                         class="img-responsive" alt="">-->
                    <!--                    <img src="" class="img-responsive" alt="" id="img2">-->
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name" id="nickname2">
                        <!--                        --><?php //echo $row['nickname']; ?>
                    </div>
                    <div class="profile-usertitle-job" id="tier2">
                        <!--                        티어-->
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons" id="btn2">
                    <!--                    --><?php
                    //                    if ($nickname == $_SESSION['nickname']) {
                    //                        ?>
                    <!--                        <button type="button" class="btn btn-primary"-->
                    <!--                                onclick="location.href='user_edit_password_check.php'">회원정보 수정-->
                    <!--                        </button>-->
                    <!--                        <button type="button" class="btn btn-info">친구 목록 관리</button>-->
                    <!--                        --><?php
                    //                    } else {
                    //                        ?>
                    <!--                        <button type="button" class="btn btn-success">친구 맺기</button>-->
                    <!--                        <button type="button" class="btn btn-secondary">메세지</button>-->
                    <!--                        <button type="button" class="btn btn-danger">차단</button>-->
                    <!--                        --><?php
                    //                    }
                    //                    ?>
                    <!--                                            <button type="button" class="btn btn-success">친구 맺기</button>-->
                    <!--                                            <button type="button" class="btn btn-secondary">메세지</button>-->
                    <!--                                            <button type="button" class="btn btn-danger">차단</button>-->
                </div>
            </div>
            <br>
            <button type="button" class="btn btn-secondary btn-lg btn-block" id="opponent_ready" value="waiting"
                    style="display: none; pointer-events: none">준비중
            </button>
            <br>
            <button type="button" class="btn btn-danger btn-lg btn-block" id="btn_kick" onclick="kick()"
                    style="display: none;">추방
            </button>
        </div>

        <br>
        <div class="container" style=" background: #306e81;height:430px;max-height: 430px;">
            <br>
            <h3>방제: <?= $title; ?></h3>
            <?php
            if ($is_public != 1) {
                ?>
                <h3>비밀번호: <?= $password ?></h3>
                <?php
            }
            ?>
            <div class="chat" id="messages"
                 style="overflow:auto;overflow-x:hidden;background:  #358094;height:250px;max-height: 250px;">
                <!--                --><?php
                //                $sql = "(SELECT * FROM message JOIN user ON message.user_id = user.id ORDER BY message_id DESC LIMIT 20) ORDER BY message_id;";
                //                $result = mysqli_query($conn, $sql);
                //
                //                while ($row = mysqli_fetch_array($result)) {
                ////                           echo "<div>".$row['nickname'].": ".$row['message_text']."<small class=\"form-text text-muted\" style='float:right;'>".$row['message_datetime']."</small></div>";
                //                    echo "<div>" . $row['nickname'] . ": " . $row['message_text'] . "</div>";
                //                }
                //                ?>

            </div>
            <br>
            <div class="input-group-append">
                <input type="text" class="form-control" id="chat"
                       onkeypress="if(event.keyCode==13) {submit(); return false;}"
                       name="chat" placeholder="메시지">
                <input type="button" value="전송" style="float:right;" id="btn_chat"
                       name="btn_chat" onclick="submit()" class="btn btn-secondary">
            </div>
            <br>
        </div>
    </div>
</div>
<!--<button type="button" class="btn btn-primary" onclick="loadURL()">로드</button>-->
<!--<h1 id="hcheck" class="hcheck">2222</h1>-->
<!--<form method="post" action="omok_test_result.php" hidden>-->
<!--    <label for="is_white"></label>-->
<!--    <input id="is_white" name="is_white" hidden value="true">-->
<!--</form>-->
</body>

<script language="Jscript">
    // var socket= io.connect("http://192.168.122.138:8888");
    var socket = io("http://192.168.122.138:8888/");
    var color = 'black';

    var chief = '';

    // 룸에 입장
    socket.emit('joinRoom', {
        room: <?=$room_id;?>,
        name: "<?=$_SESSION['nickname'];?>",
        id: <?=$_SESSION['id'];?>,
        //is_chief: "<?//=($is_make == 'true')?"true":"false";?>//",
        link_profile: "<?=($_SESSION['link_profile'] != null) ? $_SESSION['link_profile'] : "images/default_profile.png"; ?>"
    });

    // function showRooms() {
    //     socket.emit("showRooms", {});
    // }
    var is_ended = false;

    function submit() {
        if (document.getElementById("chat").value !== "") {
            socket.emit("chatIn", {
                uid: <?=$_SESSION['id'];?>,
                name: "<?=$_SESSION['nickname'];?>",
                room: <?=$room_id;?>,
                msg: document.getElementById("chat").value,
                type: 1,
                whisper: "",
                clan: -1
            });
            document.getElementById("chat").value = "";
        }
    }

    function check_start() {
        if (document.getElementById('btn_ready').value === "ready") {
            if (document.getElementById('opponent_ready').value === "ready") {
                map_clear();
                $("#messages").append("<div style='color: #ffab00;'><b><h4>게임 시작!!</h4></b></div>");
                document.getElementById("oboard").style.pointerEvents = "auto";

                document.getElementById('btn_ready').value = "waiting";
                document.getElementById('opponent_ready').value = "waiting";

                $("#btn_kick").hide();
                $("#btn_ready").html("레디");
                $("#btn_ready").hide();
                $("#opponent_ready").html("준비중");
                $("#opponent_ready").hide();
                is_ended = false;
            }
        }
    }

    function map_clear() {

        for (var i = 1; i <= 15; i++) {
            for (var j = 1; j <= 15; j++) {
                var id = "#r" + i + "c" + j;
                var id2 = "r" + i + "c" + j;
                // $(id).removeClass("ocol-" + data.col + " ocol").addClass("ocol-" + data.col + " ocol " + data.color);
                if (document.getElementById(id2).getAttribute('value') === "1") {
                    $(id).removeClass("ocol-" + j + " ocol white").addClass("ocol-" + j + " ocol");
                } else if (document.getElementById(id2).getAttribute('value') === "2") {
                    $(id).removeClass("ocol-" + j + " ocol black").addClass("ocol-" + j + " ocol");
                }
                document.getElementById(id2).setAttribute('value', "0");
            }
        }
    }

    function end() {
        // if (!alert('게임 종료!' + (a ? "\n백 승리!" : "\n흑 승리!"))) {

        // if ()  강퇴버튼 처리 필요
        if (chief === '<?= $nickname;?>') {
            $("#btn_kick").show();
        }
        $("#btn_ready").show();
        $("#opponent_ready").html("준비중");
        $("#opponent_ready").show();

        document.getElementById("oboard").style.pointerEvents = "none";

        // for (var i = 1; i <= 15; i++) {
        //     for (var j = 1; j <= 15; j++) {
        //         var id = "#r" + i + "c" + j;
        //         var id2 = "r" + i + "c" + j;
        //         // $(id).removeClass("ocol-" + data.col + " ocol").addClass("ocol-" + data.col + " ocol " + data.color);
        //         if (document.getElementById(id2).getAttribute('value') === "1") {
        //             $(id).removeClass("ocol-" + j + " ocol white").addClass("ocol-" + j + " ocol");
        //         } else if (document.getElementById(id2).getAttribute('value') === "2") {
        //             $(id).removeClass("ocol-" + j + " ocol black").addClass("ocol-" + j + " ocol");
        //         }
        //         document.getElementById(id2).setAttribute('value', "0");
        //     }
        // }


        // }
    }

    function kick() {
        // socket.emit("kick");
        socket.emit("kick");
    }

    socket.on("kick", function (data) {
        var id = data.id;
        if (<?=$_SESSION['id'];?> !==
        id
    )
        {
            alert("방장에 의해 추방되었습니다.");
            socket.disconnect();
            document.location = 'omok_waiting_room.php';
        }
    });

    function ready() {
        // alert(document.getElementById("btn_ready").value);
        if (document.getElementById('btn_ready').value === "waiting") {
            socket.emit("ready", {state: 'ready'});
            document.getElementById('btn_ready').value = "ready";
            $("#btn_ready").html("준비완료!");
        } else {
            socket.emit("ready", {state: 'waiting'});
            $("#btn_ready").html("레디");
            document.getElementById('btn_ready').value = "waiting";
        }
        check_start();
    }

    socket.on("ready", function (data) {
        var id = data.id;
        if (<?=$_SESSION['id'];?> !==
        id
    )
        {
            if (data.state === 'ready') {
                document.getElementById('opponent_ready').value = "ready";
                $("#opponent_ready").html("준비완료!");

            }
            else {
                document.getElementById('opponent_ready').value = "waiting";
                $("#opponent_ready").html("준비중");
            }
            check_start();
        }
    });

    socket.on("chatOut", function (data) {
        $("#messages").append("<div>" + data.name + ": " + data.msg +
            "</div>");
        $("#messages").scrollTop($("#messages")[0].scrollHeight);
    });

    function stoneClick(row, col) {
        var id2 = "r" + row + "c" + col;

        if (document.getElementById(id2).getAttribute('value') === "0") {
            // $('#hcheck').html("빈칸누름");
            socket.emit("stoneIn", {
                uid: <?=$_SESSION['id'];?>,
                name: "<?=$_SESSION['nickname'];?>",
                room: <?=$room_id;?>,
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
        // alert('11');
        // alert('22');
        document.getElementById(id2).setAttribute('value', data.state);
        // alert('33');
        // $(id).attr("value").val = data.state;

        // alert('체크! '+$(id).attr("value"));
        $('#hcheck').html(data.name + "가 " + data.room + "번 방에서 " + data.color + "돌을 (" + data.row + ", " + data.col + ")자리에 두었다.<br>다음은 " + ((data.color === 'black') ? 'white' : 'black') + " 차례입니다.");
        if (data.name === "<?=$_SESSION['nickname'];?>") {
            document.getElementById("oboard").style.pointerEvents = "none";
        } else {
            document.getElementById("oboard").style.pointerEvents = "auto";
        }
        // alert('44');
        $(id).removeClass("ocol-" + data.col + " ocol").addClass("ocol-" + data.col + " ocol " + data.color);
        // if (!is_ended) {
        //     // alert('55');
        //     // setTimeout(1000);
        //     // alert('체크');
        //     // setTimeout(checkOmok(), 10000);
        //     checkOmok();
        //
        //
        //
        //
        // }
        checkOmok();
                // alert(data);
    });


    socket.on("roomIn", function (data) {

        // 방을 만들 때, 코드 실행 x
        // 방에 입장했을 경우라면, 방장에게 본인 프로필 전달, 본인에게 방장 프로필 끌어와서 장식하기
        // 두 번째 입장일 때만 이런 작업을 해 준다.
        // 방장일 때

        <!--        --><?php //if ($is_make == 'true') {?>
//        if (<?//= $nickname;?>// !== data.name) {
//            $("#pic2").html('<img src="' + data.link_profile + '" class="img-responsive" alt=""></img>');
//        }
//        <?php //}
        //        // 방장이 아닐 때
        //        else {?>
//        $("#pic2").html('<img src"');
//        <?php //}?>

        if ('<?= $nickname;?>' !== data.name) {
            $("#pic2").html('<img src="' + data.link_profile + '" class="img-responsive" alt="" style="background-color:#b6f1ff;"></img>');
            $("#nickname2").html(data.name);
            $("#tier2").html("티어");
            $("#btn2").html("<button type=\"button\" class=\"btn btn-success\">친구 맺기</button>\n" +
                "<button type=\"button\" class=\"btn btn-secondary\">메세지</button>\n" +
                "<button type=\"button\" class=\"btn btn-danger\">차단</button>");
            $("#btn_kick").show();
            chief = '<?= $nickname;?>';
            $("#btn_ready").show();
            $("#opponent_ready").html("준비중");
            $("#opponent_ready").show();
        } else {
            chief = '';

            <?php
            if ($is_make != 'true') {
            $room_id = $_GET['room_id'];
            $sql = "SELECT * FROM room WHERE room_id = $room_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $chief_id = $row['chief_id'];
            $sql = "SELECT nickname, link_profile FROM user WHERE id = $chief_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);?>


            $("#pic2").html('<img src="' + "<?=($row['link_profile'] != null) ? $row['link_profile'] : "images/default_profile.png"; ?>" + '" class="img-responsive" alt="" style="background-color:#b6f1ff;"></img>');
            $("#nickname2").html("<?=$row['nickname'];?>");
            $("#tier2").html("티어");
            $("#btn2").html("<button type=\"button\" class=\"btn btn-success\">친구 맺기</button>\n" +
                "<button type=\"button\" class=\"btn btn-secondary\">메세지</button>\n" +
                "<button type=\"button\" class=\"btn btn-danger\">차단</button>");
            $("#opponent_ready").show();
            <?php
            }
            ?>

        }


        //<img src="<?php //echo ($row['link_profile'] != null) ? $row['link_profile'] : "images/default_profile.png"; ?>//"
        //class="img-responsive" alt="">
        $("#messages").append("<div style='color: #fff671;'><b><h4>" + data.name + "님이 입장하셨습니다.</h4></b></div>");
        $("#messages").scrollTop($("#messages")[0].scrollHeight);

    });
    socket.on("roomOut", function (data) {
        // 누군가 나갈 때 남아있는 사람이 방장으로 바뀌는 처리를 해준다.
        // 게임을 시작해도 이 변수는 계속 남아있게 한다.
        // 변수를 자바스크립트에 넣고, 게임종료시 조건문을 넣어 처리하자.
        $("#pic2").html("");
        $("#nickname2").html("");
        $("#tier2").html("");
        $("#btn2").html("");
        $("#messages").append("<div style='color: #fff671;'><b><h4>" + data.name + "님이 방을 떠나셨습니다.</h4></b></div>");
        $("#messages").scrollTop($("#messages")[0].scrollHeight);
        $("#btn_kick").hide();
        $("#btn_ready").hide();
        $("#opponent_ready").html("준비중");
        $("#opponent_ready").hide();
    });

    function checkOmok() {
        setTimeout(1000);
        var is_done = false;
        for (var i = 1; i <= 15; i++) {
            for (var j = 1; j <= 15; j++) {
                var is_omok = false;
                var id = "#r" + i + "c" + j;
                var id2 = "#r" + (i + 1) + "c" + j;
                var id3 = "#r" + (i + 2) + "c" + j;
                var id4 = "#r" + (i + 3) + "c" + j;
                var id5 = "#r" + (i + 4) + "c" + j;
                if ($(id).attr("value") !== "0" && $(id).attr("value") !== undefined) {
                    if ($(id).attr('value') === $(id2).attr('value')) {
                        if ($(id2).attr('value') === $(id3).attr('value')) {
                            if ($(id3).attr('value') === $(id4).attr('value')) {
                                if ($(id4).attr('value') === $(id5).attr('value')) {
                                    is_omok = true;
                                    is_ended = true;
                                    color = 'black';
                                    alert('게임 종료!' + (($(id).attr("value") === "1") ? "\n백 승리!" : "\n흑 승리!"));
                                    end();
                                    // is_done = true;
                                }
                            }
                        }
                    }
                }
                var iid2 = "#r" + i + "c" + (j + 1);
                var iid3 = "#r" + i + "c" + (j + 2);
                var iid4 = "#r" + i + "c" + (j + 3);
                var iid5 = "#r" + i + "c" + (j + 4);
                if ($(id).attr("value") !== "0" && $(id).attr("value") !== undefined) {
                    if ($(id).attr('value') === $(iid2).attr('value')) {
                        if ($(iid2).attr('value') === $(iid3).attr('value')) {
                            if ($(iid3).attr('value') === $(iid4).attr('value')) {
                                if ($(iid4).attr('value') === $(iid5).attr('value')) {
                                    is_omok = true;
                                    is_ended = true;
                                    color = 'black';
                                    alert('게임 종료!' + (($(id).attr("value") === "1") ? "\n백 승리!" : "\n흑 승리!"));
                                    end();
                                    // is_done = true;
                                }
                            }
                        }
                    }
                }
                var idd2 = "#r" + (i + 1) + "c" + (j + 1);
                var idd3 = "#r" + (i + 2) + "c" + (j + 2);
                var idd4 = "#r" + (i + 3) + "c" + (j + 3);
                var idd5 = "#r" + (i + 4) + "c" + (j + 4);
                if ($(id).attr("value") !== "0" && $(id).attr("value") !== undefined) {
                    if ($(id).attr('value') === $(idd2).attr('value')) {
                        if ($(idd2).attr('value') === $(idd3).attr('value')) {
                            if ($(idd3).attr('value') === $(idd4).attr('value')) {
                                if ($(idd4).attr('value') === $(idd5).attr('value')) {
                                    is_omok = true;
                                    is_ended = true;
                                    color = 'black';
                                    alert('게임 종료!' + (($(id).attr("value") === "1") ? "\n백 승리!" : "\n흑 승리!"));
                                    end();
                                    // alert('게임 종료!' + $(id).attr("value"));
                                    // is_done = true;
                                }
                            }
                        }
                    }
                }
                var idid2 = "#r" + (i + 1) + "c" + (j - 1);
                var idid3 = "#r" + (i + 2) + "c" + (j - 2);
                var idid4 = "#r" + (i + 3) + "c" + (j - 3);
                var idid5 = "#r" + (i + 4) + "c" + (j - 4);
                if ($(id).attr("value") !== "0" && $(id).attr("value") !== undefined) {
                    if ($(id).attr('value') === $(idid2).attr('value')) {
                        if ($(idid2).attr('value') === $(idid3).attr('value')) {
                            if ($(idid3).attr('value') === $(idid4).attr('value')) {
                                if ($(idid4).attr('value') === $(idid5).attr('value')) {
                                    is_omok = true;
                                    is_ended = true;
                                    color = 'black';
                                    alert('게임 종료!' + (($(id).attr("value") === "1") ? "\n백 승리!" : "\n흑 승리!"));
                                    end();
                                    // alert('게임 종료!' + $(id).attr("value"));
                                    // is_done = true;
                                }
                            }
                        }
                    }
                }
            }
        }


        // if (is_done) {
        //     if (window.confirm('게임 종료!' + (($(id).attr("value") === "1") ? "\n백 승리!" : "\n흑 승리!")) {
        //         end((($(id).attr("value") === "1") ? "1" : "2"));
        //     } else {
        //
        //     }
        //
        //     //
        //     // if (!alert('게임 종료!' + (($(id).attr("value") === "1") ? "\n백 승리!" : "\n흑 승리!")))
        // }

        // alert('66');
        // alert('77');
        // if (is_done) {
        //     // alert('88');
        //     if (alert(('게임 종료!' + (($(id).attr("value") === "1") ? "\n백 승리!" : "\n흑 승리!")))) {
        //         // They clicked Yes
        //         end(($(id).attr("value") === "1") ? "1" : "2");
        //     }
        //     else {
        //         // They clicked no
        //         end(($(id).attr("value") === "1") ? "1" : "2");
        //     }
        // }
    }


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
//echo session_save_path();
?>


