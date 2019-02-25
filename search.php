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