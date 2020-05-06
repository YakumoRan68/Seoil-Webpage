<?php include "templates/include/header.php" ?>
  <div id="adminHeader">
    <h2>계정</h2>
    <p> <!--프론트 : 헤더에 로그인 폼 넣으세요.-->
      <?php 
        if (isset($_SESSION['userid'])) {
          ?><b><?php echo htmlspecialchars($_SESSION['userid']); ?></b>으로 로그인 하셨습니다. <a href="session.php?action=logout">로그아웃</a><?php
        } else {
          ?>로그인 되어있지 않습니다.<?php //로그인 폼으로 대체 예정.
        } 
      ?>
    </p>
  </div>
  <h1>모든 게시글</h1>
<?php if (isset($results['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

<?php if (isset($results['statusMessage'])) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>
  <table>
    <tr>
      <th>글 번호</th>
      <th>작성자</th>
      <th>작성일</th>
      <th>말머리</th>
      <th>제목</th>
      <th>조회수</th>
    </tr>
<?php foreach ($results['articles'] as $article) { ?>
    <tr onclick="location='./?action=viewArticle&amp;articleId=<?php echo $article->article_id?>'">
      <td><?php echo $article->article_id ?></td>
      <td><?php echo $article->author_id ?></td>
      <td><?php echo date("Y-m-d H:i:s", $article->pub_date)?></td>
      <td><?php echo $article->category_id ?></td>
      <td><?php echo htmlspecialchars($article->title)?></td>
      <td><?php echo $article->views ?></td>
    </tr>
<?php } ?>
  </table>

  <p>총 <?php echo $results['totalRows']?> 개의 게시글<?php echo ($results['totalRows'] != 1) ? '들' : '' ?>이 있습니다.</p>
  <p><a href="session.php?action=newArticle">게시글 작성</a></p>
<?php include "templates/include/footer.php" ?>