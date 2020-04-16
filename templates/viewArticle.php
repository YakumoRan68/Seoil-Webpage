<?php include "templates/include/header.php" ?>

      <h1 style="width: 75%;"><?php echo htmlspecialchars( $results['article']->title )?></h1>
      <div style="width: 75%;"><?php echo $results['article']->content?></div>
      <p class="pubDate"><?php echo date('m d H', $results['article']->pub_date)?>일에 게시되었습니다.</p>

      <p><a href="./">홈페이지로 돌아가기</a></p>

<?php include "templates/include/footer.php" ?>