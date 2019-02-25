<body>
<?php require("util/navbar.php"); ?>

<?php
//$check = $_COOKIE['notice'];
//if (!isset($_SESSION['nickname'])) {
//    if ($check != "1") {
//        echo "<script>window.open(\"popup.php\", \"notice\", \"height=340, width=340, left=200, top=150\");</script>";
//    }
//}
//?>
<?php
$nickname = $_SESSION['nickname'];
$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game') or die("DB 연결에 실패하였습니다.");
$sql = "SELECT * FROM user WHERE nickname='" . $nickname . "';";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$user_id = $row['id'];


?>
<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
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

    /* Profile Content */
    .profile-content {
        padding: 20px;
        background: #3e667a;
        min-height: 460px;
    }
</style>

<div class="container-fluid col-10">
    <div class="row profile">
        <div class="col-md-8">
            <div class="profile-content">
                <table class="table table-hover">
                    <thead>
                    <!--                <h3 style="color: #05293a;">종합 전적</h3>-->
                    <tr class="table-dark">
                        <th>번호</th>
                        <th>방 이름</th>
                        <th>방장 이름</th>
                        <th>공개</th>
                        <th>인원</th>
                        <th>상태</th>
                    </tr>
                    </thead>
                    <tbody id="room_list">
                    <!--                    <tr class="table-dark">-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>테스트방제목1</td>-->
                    <!--                        <td>방장1</td>-->
                    <!--                        <td>오목</td>-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>대기중</td>-->
                    <!--                    </tr>-->
                    <!--                    <tr class="table-dark">-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>테스트방제목1</td>-->
                    <!--                        <td>방장1</td>-->
                    <!--                        <td>오목</td>-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>대기중</td>-->
                    <!--                    </tr>-->
                    <!--                    <tr class="table-dark">-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>테스트방제목1</td>-->
                    <!--                        <td>방장1</td>-->
                    <!--                        <td>오목</td>-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>대기중</td>-->
                    <!--                    </tr>-->
                    <!--                    <tr class="table-dark">-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>테스트방제목1</td>-->
                    <!--                        <td>방장1</td>-->
                    <!--                        <td>오목</td>-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>대기중</td>-->
                    <!--                    </tr>-->
                    <!--                    <tr class="table-dark">-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>테스트방제목1</td>-->
                    <!--                        <td>방장1</td>-->
                    <!--                        <td>오목</td>-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>대기중</td>-->
                    <!--                    </tr>-->
                    </tbody>
                </table>
                <!--                <a href="http://192.168.122.138/omok_test.php" class="btn btn-danger btn-lg" style="float:right;">빠른-->
                <!--                    입장</a>-->
                <!--                <button type="button" class="btn btn-danger btn-lg" style="float:right;">빠른 입장</button>-->
                <button type="button" class="btn btn-warning btn-lg" style="float:right;" id="makeRoom"
                        data-toggle="modal"
                        data-backdrop="false" data-target="#myModal">방 만들기
                </button>
                <br><br><br>
                <div class="container"
                     style="padding-top: initial; background: #306e81;height:400px;max-height: 400px;">
                    <br>
                    <h3>채팅</h3>
                    <div class="chat" id="messages"
                         style="overflow:auto;overflow-x:hidden;background:  #358094;height:250px;max-height: 250px;">
                        <?php
                        $sql = "(SELECT * FROM message JOIN user ON message.user_id = user.id WHERE room_id = -1  ORDER BY message_id DESC LIMIT 20) ORDER BY message_id;";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_array($result)) {
//                           echo "<div>".$row['nickname'].": ".$row['message_text']."<small class=\"form-text text-muted\" style='float:right;'>".$row['message_datetime']."</small></div>";
                            echo "<div>" . $row['nickname'] . ": " . $row['message_text'] . "</div>";
                        }
                        ?>


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
                    <!--                    <li class="nav-item dropdown show">-->
                    <!--                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true">Dropdown</a>-->
                    <!--                        <div class="dropdown-menu show" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">-->
                    <!--                            <a class="dropdown-item" href="#">Action</a>-->
                    <!--                            <a class="dropdown-item" href="#">Another action</a>-->
                    <!--                            <a class="dropdown-item" href="#">Something else here</a>-->
                    <!--                            <div class="dropdown-divider"></div>-->
                    <!--                            <a class="dropdown-item" href="#">Separated link</a>-->
                    <!--                        </div>-->
                    <!--                    </li>-->
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="<?php echo ($_SESSION['link_profile'] != null) ? $_SESSION['link_profile'] : "images/default_profile.png"; ?>"
                         class="img-responsive" alt="" style="background-color:#b6f1ff;">
                    <!--                    <img src="-->
                    <?php //echo (($row_['link_profile'] != null) ? $row_['link_profile'] : "../images/default_profile.png"); ?><!--"-->
                    <!--                         class="img-responsive" alt="">-->
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $nickname; ?>
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
            <br>
            <div class="profile-sidebar">
                <div class="profile-content" id="current_user">
<!--                    <table class="table table-hover" >-->
<!--                        <tbody id="current_user">-->
<!--                        --><?php
//                        $dir = opendir("/var/lib/php/sessions");
//                        $onSession = 0;
//                        while (($read = readdir($dir)) !== false) {
//                            $when_read = explode("_", $read);
//                            $read0 = $when_read[0];
//                            if ($read0 == "sess") {
//                                $fh = fopen('/var/lib/php/sessions/' . $read, 'r');
//                                while (!feof($fh)) {
//                                    $vContent = fread($fh, 2098);
////                                session_start();
////                                session_decode($vContent);
////                                echo $_SESSION['nickname'].'<br>';
////                                session_destroy();
////                                session_unset();
//                                    $str_arr = explode('nickname', $vContent);
//                                    $nick_find = explode('"', $str_arr[1]);
//                                    $nick = $nick_find[1];
//
//                                    $sql = "SELECT * FROM user WHERE nickname = '$nick' LIMIT 1";
//                                    $result = mysqli_query($conn, $sql);
//                                    $row = mysqli_fetch_array($result);
//                                    if ($row != '')
//                                        echo ' <tr class="table-dark">
//                                    <td><a class="nav-link" href="../user_profile.php?nickname=' . $nick . '" ><img class="media-object" style="width: 32px; height: 32px;border-radius: 16px; margin-right:10px; background-color:#b6f1ff;" src="' . (($row['link_profile'] != null) ? $row['link_profile'] : "images/default_profile.png") . '" ><b>' . $nick . ' </b></a></td></tr>';
//                                    //                                        echo $nick;
////                                        <img class="media-object" style="width: 24px; height: 24px;border-radius: 12px; margin-right:10px; float: right;" onclick="whisper()" src="images/whisper.png"/>
//
//                                }
//                                fclose($fh);
//                                IF (0 < strlen($vContent)) {
//                                    $onSession++;
//                                }
//                            }
//                        }
//                        echo "<h5>현재 " . $onSession . "명 접속중입니다.</h5>";
//
//                        ?>
<!--                        </tbody>-->
<!--                    </table>-->
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">방 만들기</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="omok_room.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <p>방이름</p>
                            <div class="input-group-append">
                                <input type="text" class="form-control" id="title" name="title" placeholder="제목"
                                       list="titleExample" required>
                                <datalist id="titleExample">
                                    <option value="즐겜 하실분 와주세요"></option>
                                    <option value="1:1 초고수만"></option>
                                    <option value="고수초빙"></option>
                                </datalist>
                            </div>
                        </div>
                        <div class="form-group">
                            <p>비밀번호 (선택)</p>
                            <div class="input-group-append">
                                <input type="text" class="form-control" id="password"
                                       name="password" placeholder="비밀번호">
                            </div>
                        </div>
                        <input type="text" hidden id="is_make" name="is_make" value="true">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">방 만들기</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="pwCheck">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">비밀번호 확인</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="omok_room.php?room_id=" id="modal_form">
                    <div class="modal-body">
                        <p>비공개 방입니다. 비밀번호를 입력해 주세요.</p>
                        <div class="input-group-append">
                            <input type="text" class="form-control" id="password"
                                   name="password" placeholder="비밀번호">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">입장하기</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--<button type="button" class="btn btn-primary" onclick="loadURL()">로드</button>-->
<!--<h1 id="hcheck" class="hcheck">2222</h1>-->
<form method="post" action="omok_test_result.php" hidden>
    <label for="is_white"></label>
    <input id="is_white" name="is_white" hidden value="true">
</form>
</body>

<script language="Jscript">

    $("#messages").scrollTop($("#messages")[0].scrollHeight);

    $("#messages").scroll(checkScrollPosition).scroll();
    var page = 1;
    var isLoading = false;


    function checkScrollPosition() {

        // alert('체크'+ $(document).scrollHeight;
        // $('#hcheck').html("123" + $('#messages').scrollTop());
        // alert('체크 '+$('#messages').height + "|||||||||||   "+$('#messages').scrollTop);
        if ($('#messages').scrollTop() === 0 && !isLoading) {
            isLoading = true;
            setTimeout(loadNewPage, 800);
        }
    }

    function whisper() {
        alert('귓말');
    }


    function roomPw(room_id) {
        var url = "omok_room.php?room_id=" + room_id;
        // alert(url);
        // $("#modal_form").action = url;
        document.getElementById("modal_form").action = url;
    }

    function loadNewPage() {
        page++;
        var temp = $('messages').height();
        $.ajax({ // ajax실행부분
            type: "post",
            url: "loadchat.php",
            data: {
                page: page
            },
            success: function s(a) {
                // $('#emailCheck').html(a);
                // alert(a);
                if (a !== "") {
                    $('#messages').prepend(a);
                    $('#messages').scrollTop($('#messages').height() - temp);
                    // alert('체크 ' + page);
                }
                isLoading = false;
            },
            error: function error() {
                alert('시스템 문제발생');
            }
        });
    }

    function loadCurrentUser() {
        $.ajax({
            url: "current_user.php",
            success: function s(a) {
                $("#current_user").empty();
                $("#current_user").append(a);
                setTimeout(loadCurrentUser, 5000);
            },
            error: function error() {
                alert('시스템 문제발생');
            }
        });
    }

    loadCurrentUser();

    // var socket= io.connect("http://192.168.122.138:8888");
    var socket = io("http://192.168.122.138:8888/");


    var color = 'black';

    // 룸에 입장
    socket.emit('joinRoom', {
        room: -1
    });

    // socket.emit('showt', {room:-1});

    function submit() {
        if (document.getElementById("chat").value !== "") {
            socket.emit("chatIn", {
                uid: <?=$_SESSION['id'];?>,
                name: "<?=$_SESSION['nickname'];?>",
                room: -1,
                msg: document.getElementById("chat").value,
                type: 1,
                whisper: "",
                clan: -1
            });
            document.getElementById("chat").value = "";
        }
    }


    socket.on("showRooms", function (data) {
        $("#room_list").empty();
        $("#room_list").append(data.rooms);
        console.log("!!!", data);
    });

    socket.on("chatOut", function (data) {
        //
        // $("#messages").append("<div>" + data.name + ": " + data.msg +
        //     "<small class='form-text text-muted' style='float: right;'> "+
        //     "</small></div>");

        $("#messages").append("<div>" + data.name + ": " + data.msg +
            "</div>");
        $("#messages").scrollTop($("#messages")[0].scrollHeight);
        //
        // var id = "#r" + data.row + "c" + data.col;
        // var id2 = "r" + data.row + "c" + data.col;
        // // a가 1, 흰돌 두기
        // // a가 2, 검은돌 두기
        // // a가 10, 흰 승
        // // a가 20, 검 승
        // $(id).removeClass("ocol-" + data.col + " ocol").addClass("ocol-" + data.col + " ocol " + data.color);
        // document.getElementById(id2).setAttribute('value', data.state);
        // $('#hcheck').html(data.name + "가 " + data.room + "번 방에서 " + data.color + "돌을 (" + data.row + ", " + data.col + ")자리에 두었다.");

        // alert(data);
    });


</script>
