<?php
session_start();
session_start();
if ($_SESSION['email'] == '') echo "<script>if (window.location.pathname !== '/login.php' && window.location.pathname !== '/register.php'&& window.location.pathname !== '/register_result.php')document.location='login.php';</script>";
?>
<link rel="stylesheet" href="../node_modules/bootswatch/dist/superhero/bootstrap.min.css">
<div class="bs-component">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../main.php">고 오목!</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
                aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="../notice.php">공지사항</a></li>
                <li class="nav-item"><a class="nav-link" href="omok_waiting_room.php">대기실</a></li>
<!--                <li class="nav-item"><a class="nav-link" href="#">체스</a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="#">배틀쉽</a></li>-->
            </ul>
            <form class="form-inline my-2 my-lg-0" action="../user_profile.php">
                <input class="form-control mr-sm-2" type="text" name="nickname" placeholder="닉네임">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">유저 검색</button>
            </form>
            <ul class="navbar-nav mr-lg-2">
                <?php
                // 세션이 설정되어 있는 경우 로그인 상태로 간주한다.
                // 만약 로그인 된 상태라고 확인되면 데이터베이스에서 유저 정보를 가져와 닉네임을 보여준다.
                if (isset($_SESSION['email'])) {
                    $email_ = $_SESSION['email'];
                    $conn_ = mysqli_connect('localhost', 'root_', 'zxc123', 'game', 3306) or die("<script>alert('DB연결에 실패했습니다. 관리자에게 문의해주세요!');document.location='main.php'; </script>");
                    $sql_ = "SELECT * FROM user WHERE email = '$email_'";
                    $result_ = mysqli_query($conn_, $sql_);
                    $row_ = mysqli_fetch_array($result_);
                    $nickname_ = $row_['nickname'];
                    echo '<li class="nav-item"><a class="nav-link" href="../user_profile.php?nickname=' . $nickname_ . '" ><img class="media-object" style="width: 32px; height: 32px;border-radius: 16px; margin-right:10px; background-color:#b6f1ff;" src="' . (($row_['link_profile'] != null) ? $row_['link_profile'] : "../images/default_profile.png") . '" ><b> 안녕하세요.  ' . $nickname_ . ' 님!</b></a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="../logout.php" style="margin-top:3px;">로그아웃</a></li>';
                } // 로그인 되어 있지 않은 경우
                else {
                    echo '<li class="nav-item"><a class="nav-link" href="../login.php">로그인</a></li>
                           <li class="nav-item"><a class="nav-link" href="../register.php">회원가입</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</div>
<!--<div class="bb">-->
<!--    <button type="button" class="btn btn-primary">Primary</button>-->
<!--    <button type="button" class="btn btn-secondary">Secondary</button>-->
<!--    <button type="button" class="btn btn-success">Success</button>-->
<!--    <button type="button" class="btn btn-info">Info</button>-->
<!--    <button type="button" class="btn btn-warning">Warning</button>-->
<!--    <button type="button" class="btn btn-danger">Danger</button>-->
<!--    <button type="button" class="btn btn-link">Link</button>-->
<!--</div>-->
<script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="../node_modules/jquery/dist/jquery.min.js"></script>