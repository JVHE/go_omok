<?php
session_start();
//로그인이 이미 되어 있을 경우
if (isset($_SESSION['email'])) {
    echo "<script>alert('올바르지 않은 접근입니다. 대문으로 돌아갑니다.');document.location='omok_waiting_room.php'; </script>";
}

$email = $_POST['email'];
$password = $_POST['password'];
$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game') or die("DB 연결에 실패하였습니다.");
$sql = "SELECT * FROM user WHERE email='" . $email . "' AND password='" . $password . "';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row == null) {
    echo "<script>alert('아이디 또는 비밀번호가 일치하지 않습니다.');document.location='login.php'; </script>";
} else {
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['nickname'] = $row['nickname'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['link_profile'] = $row['link_profile'];
//    $_SESSION['authority'] = $row['authority'];
    echo "<script>alert('환영합니다! " . $row['nickname'] . "님!');document.location='omok_waiting_room.php'; </script>";
}
mysqli_close($conn);
?>
