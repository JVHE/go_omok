<?php
session_start();
?>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>

<?php require("util/navbar.php"); ?>
<div class="container">
    <div class="jumbotron">

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6" style="float:left;">

                <h1>비밀번호를 다시한번 입력해주세요!</h1>
                <form method="post" action="user_edit.php">
                    <b>비밀번호<br></b>
                    <input type="password" size=20 maxlength=20 name="password" class="form-control"
                           placeholder="password"><br>
                    <input type="submit" class="btn btn-success" style="float:right" value="확인"/>
                    <input type="hidden" name="pwd_way" value="true">

                </form>
            </div>
        </div>
    </div>

</div>