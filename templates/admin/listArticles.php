<?php include "templates/include/header.php" ?>
  <div id="adminHeader">
    <h2>관리자</h2>
    <p><b><?php echo htmlspecialchars($_SESSION['username']) ?></b>으로 로그인 하셨습니다. <a href="admin.php?action=logout"?>로그아웃</a></p>
  </div>
  <h1>모든 게시글</h1>
<?php if ( isset($results['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

<?php if ( isset($results['statusMessage'])) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>
  <table>
    <tr>
      <th>글 번호</th>
      <th>작성일</th>
      <th>말머리</th>
      <th>제목</th>
      <th>조회수</th>
    </tr>
<?php foreach ($results['articles'] as $article) { ?>
    <tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->article_id?>'">
      <td><?php echo $article->article_id ?></td>
      <td><?php echo date("Y-m-d H:i:s", $article->pub_date)?></td>
      <td><?php echo $article->category_id ?></td>
      <td><?php echo htmlspecialchars($article->title)?></td>
      <td><?php echo $article->views ?></td>
    </tr>
<?php } ?>
  </table>

  <p>총 <?php echo $results['totalRows']?> 개의 게시글<?php echo ($results['totalRows'] != 1) ? '들' : '' ?>이 있습니다.</p>
  <p><a href="admin.php?action=newArticle">게시글 작성</a></p>
<?php include "templates/include/footer.php" ?>