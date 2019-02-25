<?php
session_start();
//로그인이 안되어 있는 경우
if (!isset($_SESSION['email'])) {
    session_destroy();
    echo "<script>alert('올바르지 않은 접근입니다!!');document.location='login.php'; </script>";
} else{
    session_destroy();
    echo "<script>alert('로그아웃!');document.location='login.php'; </script>";
}
//$prevPage = $_SERVER['HTTP_REFERER'];
// 변수에 이전페이지 정보를 저장
// 페이지 이동
?>