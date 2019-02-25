<head>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>

<?php
session_start();
if ($_SESSION['email'] == '') echo "<script>document.location='login.php';</script>";
?>
<?php require("util/navbar.php"); ?>
<div class="container">
    <div class="jumbotron">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon-upload"></span>
                &nbsp;&nbsp;공지사항</h3>
        </div>
        <div class="panel-body">
            <div class="media">
                <div class="media-left">
                    <a href="#"><img class="media-object" src="images/alphago.jpg" alt="빠른 대전 업데이트"
                                     style="width: 64px; height: 64px;"> </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a href="#"> 인공지능 대전 업데이트(2018/7/12)</a>&nbsp;<span class="badge">New</span>
                    </h4>
                    여러분의 관심사와 흥미를 빅 데이터로 분석하여 가장 좋은 반응을 이끌어낼 만한 기능을 만들었습니다. 많은 관심과 사랑 바랍니다.
                </div>
            </div>
            <div class="media">
                <div class="media-left">
                    <a href="#"><img class="media-object" src="images/quick.png" alt="빠른 대전 업데이트"
                                     style="width: 64px; height: 64px;"> </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a href="#"> 빠른 대전 업데이트(2018/7/12)</a>&nbsp;<span class="badge">New</span>
                    </h4>
                    빠른 대전 기능이 업데이트 되었습니다.
                    빠른 대전을 통해서 좀 더 빠르게 게임을 시작할 수 있습니다.
                    빠른 대전 버튼으로 바로 게임을 즐겨보세요!
                </div>
            </div>
            <div class="media">
                <div class="media-left">
                    <a href="#"><img class="media-object" src="images/chat.png" alt="채팅 기능 업데이트"
                                     style="width: 64px; height: 64px;"> </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a href="#">채팅 기능 업데이트(2018/7/11)</a>&nbsp;<span class="badge">New</span>
                    </h4>
                    채팅 기능이 업데이트 되었습니다.
                    자신의 의견도 표출해보세요!
                    단, 부적절한 채팅을 하게 되면 제재될 수 있습니다.
                </div>
            </div>
            <div class="media">
                <div class="media-left">
                    <a href="#"><img class="media-object" src="images/chat.png" alt="채팅 기능 업데이트"
                                     style="width: 64px; height: 64px;"> </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a href="#">1월 25일 정기점검 안내(2018/7/10)</a>
                    </h4>
                    7월 10일 04:00부터 05:00까지 정기점검이 있을 예정입니다.<br>
                    점검 내용: 서버 업데이트 및 버그 수정
                </div>
            </div>
            <div class="media">
                <div class="media-left">
                    <a href="#"><img class="media-object" src="images/chat.png" alt="채팅 기능 업데이트"
                                     style="width: 64px; height: 64px;"> </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a href="#">공지사항 페이지 테스트(2018/7/10)</a>
                    </h4>
                    테스트.
                </div>
            </div>
        </div>
    </div>
</div>