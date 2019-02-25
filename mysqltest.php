<?php
$conn = mysqli_connect('localhost', 'root', 'zxc123', 'test',3306) or die(mysqli_error($conn));
if ($conn) {
    echo '성공';
} else {
    echo '실패';
}
?>