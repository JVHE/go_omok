<?php
$email = $_POST['email'];
$nickname = $_POST['nickname'];
$conn = mysqli_connect('localhost', 'root_', 'zxc123', 'game') or die("DB 연결에 실패하였습니다.");
//        echo "<script>alert('받아온 이름: " . $name . "');</script>";
$password = $_POST['password'];
$password_confirmation = $_POST['password_confirmation'];

if ($email == '' || $nickname == '' || $password == '' || $password_confirmation == '') {
    echo "<script>alert('올바르지 않은 접근입니다. 대문으로 돌아갑니다.');document.location='main.php'; </script>";
    return;
}


if ($_FILES['profile_image']['tmp_name'] != null) {
    $target_dir = "images/user_profile/";
    $uploadOk = 1;
    $imageFileType = pathinfo($_FILES['profile_image']["name"], PATHINFO_EXTENSION);
    $target_file = $target_dir . $email . '.' . $imageFileType;
// 파일 사이즈 예외처리
    if ($_FILES["profile_image"]["size"] > 524288) {
//                    echo "Sorry, your file is too large.";
        echo "<script>alert('경고! 파일 사이즈가 너무 큽니다!(512K 이내)');history.back();</script>";
        $uploadOk = 0;
    } // Allow certain file formats
    else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"
        && $imageFileType != "GIF") {
//                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo "<script>alert('죄송합니다! JPG, JPEG, PNG, GIF만 허용됩니다. 현재: " . $imageFileType . "');history.back();</script>";
        $uploadOk = 0;
    } // Check if $uploadOk is set to 0 by an error
    else if ($uploadOk == 0) {
//                    echo "Sorry, your file was not uploaded.";
        echo "<script>alert('파일 전송 실패');history.back();</script>";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
//            echo "<script>alert('파일 전송 완료');</script>";
            $sql = "INSERT INTO user (email, password, nickname, link_profile) VALUES ('$email', '$password', '$nickname', '$target_file')";
            if ($conn->query($sql) === TRUE) {
                session_start();
                $sql = "SELECT * FROM user WHERE email='" . $email . "' AND password='" . $password . "';";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $email;
                $_SESSION['nickname'] = $nickname;
                $_SESSION['link_profile'] = $row['link_profile'];

                require("util/navbar.php");
                echo "<h1 class=\"text-center\">회원가입 성공</h1>";

                echo "<h2 class=\"text-center\">환영합니다. " . $nickname . "님.</h2><br>";
//                echo "<h2 class=\"text-center\">(POST확인용)id:<br> " . $row['id'] . "</h2><br>";
                echo "<h2 class=\"text-center\">email:<br> " . $email . "</h2><br>";
//                echo "<h2 class=\"text-center\">(POST확인용)password:<br> " . $password . "</h2><br>";
                echo "<h2 class=\"text-center\">이미지 링크: " . $target_file . "</h2>";
                echo "<div class=\"text-center\">";
                echo "<img class=\"media-object-center\" src=\"" . $target_file . "\" style=\"width: 64px; height: 64px;\"></div>";
                echo "<h2 class=\"text-center\">게임랜드 <a href=\"omok_waiting_room.php\">시작하기</a></h2>";

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }


        } else {
//                        echo "Sorry, there was an error uploading your file.";
            echo "<script>alert('죄송합니다. 파일 전송에 실패하였습니다.');</script>";
        }
    }

} else {
//                echo "<script>alert('이미지 전송 실패 or 이미지 없음');</script>";

    $sql = "INSERT INTO user (email, password, nickname) VALUES ('$email', '$password', '$nickname')";
    if ($conn->query($sql) === TRUE) {
        session_start();
        $sql = "SELECT * FROM user WHERE email='" . $email . "' AND password='" . $password . "';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $email;
        $_SESSION['nickname'] = $nickname;

        require("util/navbar.php");
        echo "<h1 class=\"text-center\">회원가입 성공</h1>";

        echo "<h2 class=\"text-center\">환영합니다. " . $nickname . "님.</h2><br>";
//        echo "<h2 class=\"text-center\">(POST확인용)id:<br> " . $row['id'] . "</h2><br>";
        echo "<h2 class=\"text-center\">email:<br> " . $email . "</h2><br>";
//        echo "<h2 class=\"text-center\">(POST확인용)password:<br> " . $password . "</h2><br>";
        echo "<h2 class=\"text-center\">게임랜드 <a href=\"omok_waiting_room.php\">시작하기</a></h2>";

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
mysqli_close($conn);

?>
