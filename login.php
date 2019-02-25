<?php
session_start();
if ($_SESSION['email'] != '') echo "<script>document.location='main.php';</script>"
?>
<?php require("util/navbar.php");

//// php.ini파일 찾기 위한 작업
//$inipath = php_ini_loaded_file();
//if ($inipath) {
//    echo 'Loaded php.ini: ' . $inipath;
//} else {
//    echo 'A php.ini file is not loaded';
//}

?>

<div class="container">
    <div class="jumbotron">

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6" style="float:left;">
                <h2>이젠 고 오목!에서 오목을 즐기세요!</h2>
                <br><br>
                <p>고 오목!은 여러명의 유저가 인터넷에서 <strong>실시간</strong>으로 오목을 즐길 수 있도록 만든 게임 사이트입니다.</p>
<!--                <p>-->
<!--                    <small>This line of text is meant to be treated as fine print.</small>-->
<!--                </p>-->
                <p><strong>여러분의 실력을 뽐내보세요!</strong></p>
                <br>
                <p>고 오목!은 무료 게임 사이트입니다.</p>
<!--                <p>The following is <strong>rendered as bold text</strong>.</p>-->
<!--                <p>The following is <em>rendered as italicized text</em>.</p>-->
<!--                <p>An abbreviation of the word attribute is <abbr title="attribute">attr</abbr>.</p>-->
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <form method="post" action="login_result.php">
                    <!--                <fieldset>-->

                    <h1>로그인</h1>
                    <div class="form-group">
                        <label for="email">이메일 아이디</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                               placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">저희는 누구에게도 여러분들의 이메일 주소를 공개하지 않습니다.
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password">비밀번호</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-success">로그인</button>
                    <a href="register.php" style="float:right;" class="btn btn-primary">회원 가입</a>
                    <!--                </fieldset>-->
                </form>
            </div>
        </div>
    </div>

</div>