<?php include "templates/include/header.php" ?>

      <h1>Article Archive</h1>

      <ul id="headlines" class="archive">

<?php foreach ( $results['articles'] as $article ) { ?>

        <li>
          <h2>
            <span class="pubDate"><?php echo date("Y-m-d H:i:s", $article->pub_date)?></span><a href=".?action=viewArticle&amp;articleId=<?php echo $article->article_id?>"><?php echo htmlspecialchars( $article->title, NULL, 'ISO-8859-1')?></a>
          </h2>
        </li>

<?php } ?>

      </ul>

      <p>총 <?php echo $results['totalRows']?>개의 게시글<?php echo ( $results['totalRows'] != 1 ) ? '들' : '' ?>이 있습니다.</p>

      <p><a href="./">홈페이지로 돌아가기</a></p>

<?php include "templates/include/footer.php" ?>