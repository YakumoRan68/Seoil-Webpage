<?php include "templates/include/header.php" ?>
  <!-- TODO(프론트) 게시글 보는 부분 레이아웃 -->
  <h1 style="width: 75%;"><?php echo $results['article']->title ?></h1>
  <div style="width: 75%;"><?php echo $results['article']->content?></div>
  <p class="pubDate"><?php echo date('m d H', $results['article']->pub_date)?>일에 게시되었습니다.</p>
  <p><a href="./?action=archive">게시판으로 돌아가기</a></p>
<?php include "templates/include/footer.php" ?>