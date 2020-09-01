<?php
  #TODO : json파일 불러오는 형식으로 바꾸기
  define('PAGE_METADATA', array( 
    array('test', '테스트 게시판', 'loadArticles' => true, 'loadComments' => true),
    array('homepage', '서뮤니티', 'loadArticles' => true),
    array('update_notice', '업데이트 공지', 'loadArticles' => true),
    array('article_support', '게시판 관련 문의', 'loadArticles' => true),
    array('support', '문의사항', 'loadArticles' => true),
    array('school_news', '학교 소식', 'loadArticles' => true),
    array('student_news', '학생 소식', 'loadArticles' => true),
    array('seoil_circle', '서일 동아리', 'loadArticles' => true),
    array('lost_report', '분실 신고', 'loadArticles' => true),
    array('found_report', '습득물 신고', 'loadArticles' => true),
    array('major_lecture', '전공강의정보', 'loadArticles' => true),
    array('general_lecture', '교양강의정보', 'loadArticles' => true),
    array('lecture_materials', '강의자료', 'loadArticles' => true),
    array('community_free', '자유게시판', 'loadArticles' => true),
    array('community_anonymous', '익명게시판', 'loadArticles' => true),
    array('community_newcomers', '새내기게시판', 'loadArticles' => true),
    array('community_graduates', '졸업생게시판', 'loadArticles' => true),
    array('about', '서일소개'),
    array('contactus', '이용문의'),
    array('privacy_policy', '개인정보 정책'),
    array('terms_of_service', '이용 약관'),

    array('testpage', '테스트 게시판 2', 'loadArticles' => true, 'loadComments' => true, 'allowAnnonymousArticle' => true, 'allowAnnonymousComment' => true),
    #'adminArticle', 'adminAccess'
  ));

  define('ARTICLES_LOAD_FOR_HOMEPAGE', array('community_free', 'test', 'lost_report', 'found_report', 'major_lecture', 'general_lecture'));
?>