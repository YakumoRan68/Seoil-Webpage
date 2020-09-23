<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo htmlspecialchars($results['pageTitle'] ?? "서뮤니티")?></title>
    <link rel="stylesheet" type="text/css" href="css/style_main.css" />
  </head>
  <body>
	<header> <!--시멘틱 태그 : 웹 페이지에서 어디가 헤더인지, 푸터인지 등등 표시해주는 html5 표준 태그; 직접 꾸밀게 아니더라도 태그해서 표시는 해야함. 소위말해 웹 국룰입니다. 반드시 지키세요.-->
		<div id="header">
			<a class="logo" href="." ><img src="images/logoSeoil.png" alt="서뮤니티 로고"/><!--이미지에는 꼭 alt 태그 넣으세요.--></a>
			<nav class="header-menu"> 
				<ul> <!--원래 클래스 이름 "nav"였음. 시멘틱 태그를 클래스이름 그대로 쓰지 마세요. 해당 ul을 지칭하는것은 .header-menu > ul 로 할 것.-->
					<li><a href="session.php?location=community_free" accesskey="2">커뮤니티</a>
						<ul>
							<li><a href="session.php?location=community_free">자유게시판</a></li>
							<li><a href="session.php?location=community_anonymous">익명게시판</a></li>
							<li><a href="session.php?location=community_newcomers">새내기게시판</a></li>
							<li><a href="session.php?location=community_graduates">졸업생게시판</a></li>
						</ul>
					</li>
					<li><a href="session.php?location=major_lecture" accesskey="3">강의정보</a>
						<ul>
							<li><a href="session.php?location=major_lecture">전공강의정보</a></li>
							<li><a href="session.php?location=general_lecture">교양강의정보</a></li>
							<li><a href="session.php?location=lecture_materials">교양강의자료</a></li>
						</ul>
					</li>
					<li><a href="session.php?location=lost_report" accesskey="4">분실물</a>
						<ul>
							<li><a href="session.php?location=lost_report">분실신고</a></li>
							<li><a href="session.php?location=found_report">습득물</a></li>
						</ul>
					</li>
					<li><a href="session.php?location=school_news" accesskey="5">공지사항</a>
						<ul>
							<li><a href="session.php?location=school_news">학교소식</a></li>
							<li><a href="session.php?location=student_news">학생소식</a></li>
							<li><a href="session.php?location=seoil_circle">서일동아리</a></li>
						</ul>
					</li>
					<li><a href="session.php?location=support" accesskey="6">운영센터</a>
						<ul>
							<li><a href="session.php?location=update_notice">업데이트 공지</a></li>
							<li><a href="session.php?location=article_support">게시판 신설건의</a></li>
							<li><a href="session.php?location=support">문의사항</a></li>
						</ul>
					</li>
				</ul>
			</nav>
			<div class="header-box-wrapper">
				<div class="header-slide-box">
					<ul>
						<li><a href="http://hm.seoil.ac.kr/"><img src="images/슬라이드1.jpg" alt="서일대홈페이지" ></a></li>
						<li><a href="https://attend.seoil.ac.kr"><img src="images/슬라이드2.jpg" alt="스마트출석부" ></a></li>
						<li><a href="https://ctl.seoil.ac.kr"><img src="images/슬라이드3.jpg" alt="교수학습지원센터" ></a></li>
						<li><a href="https://stis.seoil.ac.kr"><img src="images/슬라이드4.jpg" alt="종합정보시스템" ></a></li>
						<li><a href="https://portal.seoil.ac.kr"><img src="images/슬라이드5.jpg" alt="포털시스템" ></a></li>
					</ul>
				</div>
				<div class="profile-box">
					<?php if(isset($_SESSION['userid'])) : ?>
						<table class="userlog">
							<tr>
								<td colspan = "2"><?php echo $_SESSION['username'].'님'; ?> <a class="logout" href="session.php?action=logout">로그아웃</a> </td>
							</tr>
							<tr>
								<td><a href = "#">내가 쓴 글</a></td>
								<td><a href = "#">작성댓글</a></td>
							</tr>
						</table>
					<?php else : ?>
						<h2>서일 로그인</h2>
						<form action="session.php?action=login" method="post"><fieldset>
							<input type="hidden" name="login" value="true" />
							<div class="loginBox">
								<input type="text" name="userid" required onkeyup="this.setAttribute('value', this.value);"  value="" placeholder="아이디">
							</div>
							<div class="loginBox">
								<input type="password" name="userpw" required onkeyup="this.setAttribute('value', this.value);" value="" placeholder="비밀번호">
							</div>
							<input type="submit" name="login" value="로그인">
						</fieldset></form>
						<a href="#">아이디/비밀번호 찾기</a> <a href="session.php?action=register">회원가입</a>
					<?php endif ?>
				</div>
			</div>
		</div>
	</header>
	<div id = "wrapper">
		<div class = "ad-banner"><a href="#"><img src="images/banner_sample.jpg" alt="광고배너" ></a></div>
		<div id = "container">