<?php 
  function pageMetadata() {
    return PAGE_METADATA;
  }

  function getCategoryKey($arg) {
    $cnum = is_numeric($arg) ? $arg : array_search($arg, array_column(pageMetadata(), 0));
    return sprintf('%1$03d', $cnum);
  }

  function getCategoryName($arg) {
    $cnum = array_search($arg, array_column(pageMetadata(), 0));
    return pageMetadata()[$cnum];
  }

  function getFileName($cnum) {
    return pageMetadata()[(int)$cnum][0];
  }

  function goPage($args=array()) {
    $param = "";
    foreach($args as $k=>$v){
      $param = $param.$k."=".$v."&";
    }
    header("Location: session.php?".substr($param, 0, strlen($param)-1) );
  }

  function alert($str) {
    echo "<script type='text/javascript'> alert('{$str}'); </script>";
  }

  function error_page($reason) {
    header("Location: ".ERROR_PATH."?error=".$reason);
  }

  function hasPermissionInCurrentSession($userid) {
    return isset($_SESSION['userid']) && ($_SESSION['userid'] == $userid || $_SESSION['userid'] == ADMIN_USERNAME);
  }

  function canWriteArticle($cnum) {
    return true;
    if(isset($_SESSION['userid'])) return ((pageMetadata()[$cnum]['adminArticle'] ?? false) && $_SESSION['userid'] == 'admin') ;
    return pageMetadata()[$cnum]['allowAnnonymousArticle'] ?? false;
  }

  function tab() { #tab 리터럴 문자 반환
    return '<span class="tab">&#9;</span>';
  }
?>