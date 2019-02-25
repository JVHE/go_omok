<?php

$password_check = $_POST['password'];
$pwd_way = $_POST['pwd_way'];
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['nickname']) || !isset($pwd_way)) {
    echo "<script>alert('올바르지 않은 접근입니다!! 대문으로 돌아갑니다.');history.back(); </script>";
} else {
    if ($password_check == null) {
        echo "<script>alert('비밀번호를 입력해 주세요.');history.back(); </script>";
    } else {
        $conn = mysqli_connect(
            'localhost',
            'root_',
            'zxc123',
            'game') or die("<script>alert('DB연결에 실패했습니다. 관리자에게 문의해주세요!');history.back(); </script>");
        $sql = "SELECT * FROM user WHERE email = '" . $_SESSION['email'] . "' AND password = '" . $password_check . "';";
        $result = mysqli_query($conn, $sql) or die("아이디확인쪽");
        $row = mysqli_fetch_row($result);
        if ($row == null) {
            echo "<script>alert('비밀번호가 틀립니다!! 다시 입력해주세요.');history.back(); </script>";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>게임랜드</title>


</head>

<?php require("util/navbar.php"); ?>
<div class="container">
    <div class="jumbotron">

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <form method="post" action="user_edit_result.php" enctype="multipart/form-data">
                    <h1>회원정보 수정</h1>

                    <div class="form-group">
                        <label for="password">비밀번호</label>
                        <input type="password" class="form-control" name="password" id="password"
                               onchange="passwordCheck()" required>
                        <small class="form-text text-muted" id="passwordCheckText" value="0">비밀번호는 8 자 이상, 16글자 이하, 하나
                            이상의 숫자 및
                            대문자와 소문자, 특수 문자 모두를 포함해야합니다.
                        </small>
                        <input type="hidden" value="0" name="passwordCheckValue" id="passwordCheckValue">
                        <!--                        <span id="passwordCheckText" width="100">&nbsp;</span>-->
                        <!--                            </div>-->
                    </div>
                    <!--                        <div class="col-md-6">-->
                    <div class="form-group">
                        <label for="$password_confirmation">비밀번호 확인</label>
                        <input type="password" class="form-control" name="password_confirmation"
                               id="password_confirmation" onchange="passwordCheck()" required>
                        <small class="form-text text-muted" name="passwordConfirmText" id="passwordConfirmText">비밀번호를 다시
                            한번 입력해 주세요.
                        </small>
                        <input type="hidden" value="0" name="passwordConfirmValue" id="passwordConfirmValue">
                    </div>
                    <div class="form-group">
                        <label for="name">닉네임 (중복불가)</label>
                        <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Nickname" value="<?=$_SESSION['nickname'];?>"
                               required>
                        <div id="nicknameCheck"></div>
                        <!--                        <small class="form-text text-muted">닉네임을 설정해 주세요.</small>-->
                    </div>
                    <!--                    <div class="form-group">-->
                    <!--                        <label for="profile_image">프로필 사진 (선택)</label>-->
                    <!--                        <input type="file" class="form-control-file" name="profile_image" id="profile_image" aria-describedby="fileHelp">-->
                    <!--                        <small id="fileHelp" class="form-text text-muted">프로필 사진을 업로드해 주세요(512K 이내). 파일 형식은 JPG, JPEG,-->
                    <!--                            PNG, GIF만 가능합니다.-->
                    <!--                        </small>-->
                    <!--                    </div>-->

                    <div class="form-group">
                        <label for="profile_image">프로필 사진 (선택)</label>
                        <input type="file" class="form-control-file" name="profile_image" id="profile_image">
                        <small id="fileHelp" class="form-text text-muted">프로필 사진을 업로드해 주세요(512K 이내). 파일 형식은 JPG, JPEG,
                            PNG, GIF만 가능합니다.
                        </small>
                    </div>


                    <!--                        </div>-->
                    <!--                    </div>-->

                    <button type="submit" class="btn btn-success" onclick="return register_check()">수정</button>
                </form>
                <h3>회원탈퇴</h3>
                <form method="post" action="leave_id.php">
                    <input type="hidden" name="leave" value="true">

                    <input type="submit" value="회원 탈퇴 메뉴 바로가기"/>
                </form>
            </div>
        </div>
        <iframe src="" id="ifrm1" scrolling=no frameborder=no width=0 height=0 name="ifrm1"></iframe>
    </div>
</div>
<script language="javascript">
    function passwordCheck() {
        var passwordRules = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,16}$/;
        var password = document.getElementById("password").value;
        var password_confirmation = document.getElementById("password_confirmation").value;
        var passwordCheckText = document.getElementById('passwordCheckText');
        var passwordConfirmText = document.getElementById('passwordConfirmText');
        var passwordCheckValue = document.getElementById('passwordCheckValue');
        var passwordConfirmValue = document.getElementById('passwordConfirmValue');
        if (password.length < 8 || password > 16) {
            passwordCheckText.innerHTML = '비밀번호는 8글자 이상, 16글자 이하만 이용 가능합니다.';
            passwordCheckText.className = "form-text text-danger";
            passwordCheckValue.value = "0";
        } else if (!passwordRules.test(password)) {
            passwordCheckText.innerHTML = '비밀번호는 하나 이상의 숫자 및 대문자와 특수 문자 모두를 포함해야합니다.';
            passwordCheckText.className = "form-text text-danger";
            passwordCheckValue.value = "0";
        } else {
            passwordCheckText.innerHTML = '비밀번호 조건을 만족합니다.';
            passwordCheckText.className = "form-text text-success";
            passwordCheckValue.value = "1";
        }
        if (password !== '' && password_confirmation !== '') {
            if (password !== password_confirmation) {
                passwordConfirmText.innerHTML = '비밀번호가 일치하지 않습니다.';
                passwordConfirmText.className = "form-text text-danger";
                passwordConfirmValue.value = "0";
            } else {
                passwordConfirmText.innerHTML = '비밀번호가 일치합니다.';
                passwordConfirmText.className = "form-text text-success";
                passwordConfirmValue.value = "1";
            }
        }
        if (password === '') {
            passwordCheckText.innerHTML = '비밀번호는 8 자 이상, 16글자 이하, 하나 이상의 숫자 및 대문자와 특수 문자 모두를 포함해야합니다.';
            passwordCheckText.className = "form-text text-muted";
            passwordCheckValue.value = "0";
        }
        if (password_confirmation === '') {
            passwordConfirmText.innerHTML = '비밀번호를 다시 한번 입력해 주세요.';
            passwordConfirmText.className = "form-text text-muted";
            passwordConfirmValue.value = "0";
        }

    }

    function register_check() {

        // var passwordCheckValue = document.getElementById("passwordCheckValue");
        if (document.getElementById("passwordCheckValue").value === "0") {
            alert("비밀번호칸을 확인해 주세요.");
            document.getElementById('password').focus();
            return false;
        }
        // var passwordConfirmText = document.getElementById("passwordConfirmText");
        if (document.getElementById("passwordConfirmValue").value === "0") {
            alert("비밀번호 확인 칸을 확인해 주세요.");
            document.getElementById('password_confirmation').focus();
            return false;
        }
        // var nicknameCheckValue = document.getElementById("nicknameCheckValue");
        if (document.getElementById("nicknameCheckValue").value === "0") {
            alert("닉네임칸을 확인해 주세요.");
            document.getElementById('nickname').focus();
            return false;
        }
    }

</script>
<script language="JScript">
    $(document).ready(function () {


        $('#nickname').blur(function () {
            $.ajax({ // ajax실행부분
                type: "post",
                url: "checknickname.php",
                data: {
                    nickname: $('#nickname').val()
                },
                success: function s(a) {
                    $('#nicknameCheck').html(a);
                },
                error: function error() {
                    alert('시스템 문제발생');
                }
            });
        });


    });
</script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"/>
