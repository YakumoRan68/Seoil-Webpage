<?php include "templates/include/header.php" ?>

      <ul id="headlines">

<?php foreach ( $results['articles'] as $article ) { ?>

        <li>
          <h2>
            <span class="pubDate"><?php echo date("m d H", $article->pub_date)?></span><a href=".?action=viewArticle&amp;articleId=<?php echo $article->article_id?>"><?php echo htmlspecialchars( $article->title)?></a>
          </h2>
        </li>

<?php } ?>

      </ul>

      <p><a href="./?action=archive">Article Archive</a></p>

<?php include "templates/include/footer.php" ?>