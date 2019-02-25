<?php
/**
 * Created by PhpStorm.
 * User: JVHE
 * Date: 2019-02-22
 * Time: 8:54
 */

$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game') or die("DB 연결에 실패하였습니다.");
$dir = opendir("/var/lib/php/sessions");
$onSession = 0;
echo "<table class=\"table table-hover\" ><tbody>";
while (($read = readdir($dir)) !== false) {

    $when_read = explode("_", $read);
    $read0 = $when_read[0];
    if ($read0 == "sess") {
        $fh = fopen('/var/lib/php/sessions/' . $read, 'r');
        while (!feof($fh)) {
            $vContent = fread($fh, 2098);
//                                session_start();
//                                session_decode($vContent);
//                                echo $_SESSION['nickname'].'<br>';
//                                session_destroy();
//                                session_unset();
            $str_arr = explode('nickname', $vContent);
            $nick_find = explode('"', $str_arr[1]);
            $nick = $nick_find[1];

            $sql = "SELECT * FROM user WHERE nickname = '$nick' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            if ($row != '')
                echo ' <tr class="table-dark">
                                    <td><a class="nav-link" href="../user_profile.php?nickname=' . $nick . '" ><img class="media-object" style="width: 32px; height: 32px;border-radius: 16px; margin-right:10px; background-color:#b6f1ff;" src="' . (($row['link_profile'] != null) ? $row['link_profile'] : "images/default_profile.png") . '" ><b>' . $nick . ' </b></a></td></tr>';
        }
        fclose($fh);
        if (0 < strlen($vContent)) {
            $onSession++;
        }
    }
}
echo "<h5>현재 " . $onSession . "명 접속중입니다.</h5>";
echo "</tbody></table>";

?>