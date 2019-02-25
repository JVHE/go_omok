<?php
/**
 * Created by PhpStorm.
 * User: JVHE
 * Date: 2018-07-11
 * Time: 오후 4:18
 */

$email = $_POST['email'];
if ($email == '') {
    ?>
    <small class="form-text text-muted" id="emailCheckText" value="0">Email 주소를 입력해 주세요.</small>
    <input type="hidden" value="0" name="emailCheckValue" id="emailCheckValue">
    <?php
} else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
    ?>
    <small class="form-text text-danger" id="emailCheckText" value="0">이메일 형식을 지켜주세요.(예: example@email.com)</small>
    <input type="hidden" value="0" name="emailCheckValue" id="emailCheckValue">
    <?php
}
else {
    $conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game', 3306) or die("<script>alert('DB연결에 실패했습니다. 관리자에게 문의해주세요!');document.location='main.php'; </script>");
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_array($result);
    if ($rows == null) {
        ?>
        <small class="form-text text-success" id="emailCheckText" value="1">사용 가능한 아이디입니다.</small>
        <input type="hidden" value="1" name="emailCheckValue" id="emailCheckValue">
        <?php
    } else {
        ?>
        <small class="form-text text-danger" id="emailCheckText" value="0">아이디가 존재합니다.</small>
        <input type="hidden" value="0" name="emailCheckValue" id="emailCheckValue">
        <?php
    }
}
?>