<?php include "templates/include/header.php";?>
  <div class = "homepage-articles-wrapper"> 
      <?php #홈페이지에서 게시글 가져오는 갯수 최대수치 정하고 css에서 한 게시판 블럭크기 정해야함.
      for($i = 0; $i < count($results) - 1; $i++) : #count($array) - 1 : empty array($results = array())도 1개로 카운트.

      $pMd = PAGE_METADATA;
      $key = $results[$i]['key'];
      $location_name = $pMd[(int)$key][0];
      $articles_name = $pMd[(int)$key][1];
      ?>

      <div class = "homepage-articles-box">
        <div class = "homepage-articles-name">
          <a href = "http://localhost/session.php?location=<?php echo $location_name?>" >
            <h2><?php echo $articles_name ?></h2>
          </a>
        </div>
        <table class = "homepage-articles-list">
          <?php foreach ($results[$i]['articles'] as $article) { ?>
            <tr onclick="location='session.php?action=viewArticle&amp;categoryId=<?php echo $article->category_id.'&amp;articleId='.$article->article_id ?>'">
              <td><?php echo htmlspecialchars($article->title)?></td>
            </tr>
          <?php } ?>
          </table>
      </div>
      <?php endfor ?>
  </div>
<?php include "templates/include/footer.php" ?>

<!-- TODO(백엔드) 
- 댓글
- 목록 페이지(다음 페이지, 이전 페이지)
- 파일 업로드

- Rich Text Editor
- url 파라메터 지우기(url rewrite)
- 이미지 업로드
- 데이터 보안
-->