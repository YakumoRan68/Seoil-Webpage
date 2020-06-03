<?php include "templates/include/header.php" ?>
<?php include "templates/include/articleheader.php" ?>
  <table>
    <tr>
      <th>글 번호</th>
      <th>작성자</th>
      <th>작성일</th>
      <th>분류</th>
      <th>제목</th>
      <th>조회수</th>
    </tr>
<?php foreach ($results['articles'] as $article) { ?>
    <tr onclick="location='session.php?action=viewArticle&amp;categoryId=<?php echo $article->category_id.'&amp;articleId='.$article->article_id ?>'">
      <td><?php echo $article->article_id ?></td>
      <td><?php echo $article->author_id ?></td>
      <td><?php echo date("Y-m-d H:i:s", $article->pub_date)?></td>
      <td><?php echo $article->category_id ?></td>
      <td><?php echo htmlspecialchars($article->title)?></td>
      <td><?php echo $article->views ?></td>
    </tr>
<?php } ?>
  </table>

  <p>총 <?php echo $results['totalArticleRows']?>개의 게시글<?php echo ($results['totalArticleRows'] != 1) ? '들' : '' ?>이 있습니다.</p>
  <p><a href="./">홈페이지로 돌아가기</a></p>

<?php include "templates/include/footer.php" ?>