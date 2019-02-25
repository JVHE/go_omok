<SCRIPT language="JavaScript">
    function setCookie(name, value, expiredays){
        var todayDate = new Date();
        todayDate.setDate(todayDate.getDate() + expiredays);
        document.cookie = name + "=" + escape(value) + "; path=/; expires=" + 1000 + ";"
    }

    function closeWin(){
        if(document.checkClose.Notice.checked){
            setCookie( "notice", "1" , 1);
        }
        self.close();
    }
</SCRIPT>
<?php
$ans = $_GET['ans'];
session_start();
if ($ans == "yes") {
if (!isset($_SESSION['email']) || !isset($_SESSION['nickname'])) {
    $conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game') or die("DB 연결에 실패하였습니다.");

    $ip = $_SERVER['REMOTE_ADDR'];
    $view_record = $_COOKIE['view_record'];
    $sql = "INSERT INTO cookie_data (ip, view_record) VALUES ('$ip', '$view_record')";
    mysqli_query($conn, $sql);

    setcookie("notice", "1", 0,"/");

    echo "<script>self.close();</script>";
}}
else {
    echo "<script>self.close();</script>";
}