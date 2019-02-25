<?php
$page = $_POST['page'];

$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game', 3306) or die("<script>alert('DB연결에 실패했습니다. 관리자에게 문의해주세요!');document.location='main.php'; </script>");

$sql = "(SELECT * FROM message JOIN user ON message.user_id = user.id ORDER BY message_id DESC LIMIT " . (20 * ($page - 1)) . ", 20) ORDER BY message_id;";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
//                           echo "<div><tt>".$row['nickname'].": ".$row['message_text']."<sub class=\"form-text text-muted\">".$row['message_datetime']."</sub></div>";
    echo "<div>" . $row['nickname'] . ": " . $row['message_text'] . "</div>";
}
?>