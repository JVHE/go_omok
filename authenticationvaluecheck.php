<?php
$email = $_POST['email'];
$authentication_number = $_POST['authentication_number'];

$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game', 3306) or die("<script>alert('DB연결에 실패했습니다. 관리자에게 문의해주세요!');document.location='main.php'; </script>");
$sql = "SELECT * FROM email_authentication WHERE email = '$email' AND authentication_number = $authentication_number AND is_authenticated = 0";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($result);
if ($rows != null) {
    $sql = "UPDATE email_authentication SET is_authenticated = 1 WHERE email = '$email'";
    mysqli_query($conn, $sql);
    echo "true";
} else {
    echo "false";
}
?>