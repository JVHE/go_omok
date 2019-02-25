<?php
$email = $_POST['email'];
$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game', 3306) or die("<script>alert('DB연결에 실패했습니다. 관리자에게 문의해주세요!');document.location='main.php'; </script>");


$authentication_number = mt_rand(100000, 999999);


$sql = "INSERT INTO email_authentication VALUES (null, '$email', $authentication_number, 0, NOW())";
if ($conn->query($sql) === TRUE) {

//    echo "인증메일이 전송되었습니다. 유효기간은 30분입니다.";
//    $post = 'mail -s "게임랜드 메일인증" ' . $email . ' << EOF
//    안녕하세요.
//
//    게임랜드를 찾아주셔서 감사합니다. 이메일 인증을 하기 위한 인증번호는 다음과 같습니다.
//
//    인증번호: ' . $authentication_number . '
//
//    인증 번호는 30분간 유효합니다.
//
//    감사합니다.
//
//    =========================================================
//    대표: 이정배
//    이메일: jeongbae1212@gmail.com
//    전화: 010-0000-0000
//    ';

    $post = 'echo "Authentication number: ' . $authentication_number . '
    
    Please type authentication number.
    
    Thank you.
    =========================================================
    
    Game Land
    Email: adsf2457@naver.com
    Call: 010-0000-0000" | mail -s "게임랜드 메일인증" '. $email;

    exec($post);
} else {
    echo "DB연결에 실패했습니다. 관리자에게 문의해주세요!";
}
?>