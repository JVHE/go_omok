<HTML>
<HEAD>
    <TITLE>고 오목!을 후원해 주세요!</TITLE>
    <SCRIPT language="JavaScript">
        function setCookie(name, value, expiredays){
            var todayDate = new Date();
            todayDate.setDate(todayDate.getDate() + expiredays);
            document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";"
        }

        function closeWin(){
            if(document.checkClose.Notice.checked){
                setCookie( "notice", "1" , 1);
            }
            self.close();
        }
    </SCRIPT>
</HEAD>
<body>
<form name="checkClose">
    <h2>고 오목을 후원해 주세요!</h2>
    <hr>
    <h3>고 오목을 후원해 주세요. 광고없이 운영하느라 힘들어요 ㅠ.ㅠ 1002-030-715510 우리은행 이정배</h3>
    <input type="checkbox" name="Notice">오늘 하루 이창 띄우지 않습니다.
    <a href="popup_result.php?ans=yes">네</a>
    <a href=javascript:closeWin()>아니요</a>
</form>
</body>
</HTML>