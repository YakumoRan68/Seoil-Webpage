<?php 
  function getLocation() {
    $locations =  array( 
      array('test', '테스트게시판', true),
      array('homepage', '서뮤니티', true),
      array('update_notice', '업데이트 공지', true),
      array('article_support', '게시판 관련 문의', true),
      array('support', '문의사항', true),
      array('school_news', '학교 소식', true),
      array('student_news', '학생 소식', true),
      array('seoil_circle', '서일 동아리', true),
      array('lost_report', '분실 신고', true),
      array('found_report', '습득물 신고', true),
      array('major_lecture', '전공강의정보', true),
      array('general_lecture', '교양강의정보', true),
      array('lecture_materials', '강의자료', true),
      array('community_free', '자유게시판', true),
      array('community_anonymous', '익명게시판', true),
      array('community_newcomers', '새내기게시판', true),
      array('community_graduates', '졸업생게시판', true),
      array('about', '서일소개'),
      array('contactus', '이용문의'),
      array('privacy_policy', '개인정보 정책'),
      array('terms_of_service', '이용 약관'),


      array('testpage', '댓글 테스트', true),
    );
    return $locations;
  }

  function getCategoryKey($arg) {
    $cnum = is_numeric($arg) ? $arg : array_search($arg, array_column(getLocation(), 0));
    return sprintf('%1$03d', $cnum);
  }

  function getCategoryMetaData($arg) {
    $cnum = array_search($arg, array_column(getLocation(), 0));
    return getLocation()[$cnum];
  }

  function getFileName($cnum) {
    return getLocation()[(int)$cnum][0];
  }

  function goPage($args=array()) {
    $param = "";
    foreach($args as $k=>$v){
      $param = $param.$k."=".$v."&";
    }
    header("Location: session.php?".substr($param, 0, strlen($param)-5) );
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
?>