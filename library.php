<?php 
  function alert($str) {
    echo "<script type='text/javascript'> alert('{$str}'); </script>";
  }

  function error_page($reason) {
    header("Location: ".ERROR_PATH."?error=".$reason);
  }

  function hasPermissionInCurrentSession($userid) {
    return isset($_SESSION['userid']) && ($_SESSION['userid'] == $userid || $_SESSION['userid'] == ADMIN_USERNAME);
  }
?>