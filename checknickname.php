<?php
/**
 * Created by PhpStorm.
 * User: JVHE
 * Date: 2018-07-11
 * Time: 오후 4:18
 */

$nickname = $_POST['nickname'];
if ($nickname == '') {
    ?>
    <span class="form-text text-muted" id="nicknameCheckText" name="nicknameCheckText" value="0">닉네임을 입력해 주세요.</span>
    <input type="hidden" value="0" name="nicknameCheckValue" id="nicknameCheckValue">
    <?php
} else {
    $conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game', 3306) or die("<script>alert('DB연결에 실패했습니다. 관리자에게 문의해주세요!');document.location='main.php'; </script>");
    $sql = "SELECT * FROM user WHERE nickname = '$nickname'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_array($result);
    if ($rows == null) {
        ?>
        <span class="form-text text-success" id="nicknameCheckText" name="nicknameCheckText" value="1">사용 가능한 닉네임입니다.</span>
        <input type="hidden" value="1" name="nicknameCheckValue" id="nicknameCheckValue">
        <?php
    } else {
        ?>
        <span class="form-text text-danger" id="nicknameCheckText" name="nicknameCheckText" value="0">닉네임이 존재합니다.</span>
        <input type="hidden" value="0" name="nicknameCheckValue" id="nicknameCheckValue">
        <?php
    }
}
?>