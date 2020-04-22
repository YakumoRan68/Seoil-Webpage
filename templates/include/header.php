<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo htmlspecialchars($results['pageTitle'])?></title>
    <link rel="stylesheet" type="text/css" href="css/styleMain.css" />
  </head>
  <body>
	<header> <!--시멘틱 태그 : 웹 페이지에서 어디가 헤더인지, 푸터인지 등등 표시해주는 html5 표준 태그; 직접 꾸밀게 아니더라도 태그해서 표시는 해야함. 소위말해 웹 국룰입니다. 반드시 지키세요.-->
		<div class="header_wrapper">
			<nav class = "login"> <!--nav(시멘틱 태그) : 문서의 부분 중 현재 페이지 내, 또는 다른 페이지로의 링크를 보여주는 구획을 나타내는 용도 -->
				<a href="admin.php">로그인</a> | <a href="# ">회원가입</a>
			</nav>
			<a class="logo" href="." ><img src="images/logoSeoil.png" alt="서일대학교 커뮤니티 로고"/><!--이미지는에 꼭 alt 태그 넣으세요.--></a>
			<nav class="header_menu"> 
				<ul> <!--원래 클래스 이름 "nav"였음. 시멘틱 태그를 클래스이름 그대로 쓰지 마세요. 해당 ul을 지칭하는것은 .header_menu > ul 로 할 것.-->
					<li><a href="#" accesskey="2" title="">커뮤니티</a>
						<ul>
							<li><a href="# ">자유게시판</a></li>
							<li><a href="# ">익명게시판</a></li>
							<li><a href="# ">새내기게시판</a></li>
							<li><a href="# ">졸업생게시판</a></li>
						</ul>
					</li>
					<li><a href="#" accesskey="3" title="">강의정보</a>
						<ul>
							<li><a href="# ">전공강의정보</a></li>
							<li><a href="# ">교양강의정보</a></li>
							<li><a href="# ">교양강의자료</a></li>
						</ul>
					</li>
					<li><a href="#" accesskey="4" title="">분실물</a>
						<ul>
							<li><a href="# ">분실신고</a></li>
							<li><a href="# ">습득물</a></li>
						</ul>
					</li>
					<li><a href="#" accesskey="5" title="">공지사항</a>
						<ul>
							<li><a href="# ">학교소식</a></li>
							<li><a href="# ">학생소식</a></li>
							<li><a href="# ">서일동아리</a></li>
						</ul>
					</li>
					<li><a href="#" accesskey="6" title="">운영센터</a>
						<ul>
							<li><a href="# ">업데이트 공지</a></li>
							<li><a href="# ">게시판 신설건의</a></li>
							<li><a href="# ">문의사항</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</header>