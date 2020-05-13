에러페이지 입니다.
<?php 
    if(isset($_GET['error'])) {
        $message = "";
        switch($_GET['error']) {
            case "test" : $message = "에러테스트"; break;
            case "articleNotFound" : $message = "존재하지 않는 게시물입니다."; break;
            case "noPermission" : $message = "권한이 없습니다."; break;
            case "wrongAccount" : $message = "아이디 혹은 비밀번호를 확인하세요."; break;
            case "alreadyInSession" : $message = "이미 로그인 되어있습니다."; break;
            case "wrongUID" : $message = "잘못된 게시물 Uid값입니다."; break;
        }
        echo "<script type='text/javascript'> alert('{$message}'); </script>";
    }
    echo "<script type='text/javascript'> history.go(-1) </script>";
?>