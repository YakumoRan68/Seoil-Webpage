<?php 
  include "templates/include/header.php";
  $article = $results['article'];
  $location = pageMetadata()[(int)$article->category_id]; 
  $loadComment = pageMetadata()[(int)$article->category_id]['loadComments'] ?? false
?>
  <div id = "container">
    <div class = "content-wrapper">
      <h1 class = "page_name"><?php echo $location[1] ?></h1> 
      <hr style ="margin-bottom : 30px;">
      <div class = "article-wrapper">
        <div class = "article-metadata">
          <h3 style = "margin-bottom: 10px"><?php echo $article->title?></h3>
          <span class = "article-metadata-middle"><?php echo $article->author_id?></span>
          <span class = "article-metadata-middle"><?php echo date('Y/m/d H:i', $article->pub_date)?></span>
          <span class = "article-metadata-middle"><?php echo '조회 '.$article->views?></span>
          <?php if($loadComment) : ?>
            <span class = "article-metadata-middle"><?php echo "댓글 ".$results['totalCommentRows'] ?>
          <?php endif ?>
          <hr style ="margin : 15px 0;">
        </div>

        <div class = "article-text" id = "content"><?php echo $article->content?></div>
          
        <div class = "article-bottom">
          <?php if($loadComment) : ?>
            <span class = "comment-count"><?php echo "댓글 ".$results['totalCommentRows'] ?></span>
          <?php endif ?>
          <?php if(hasPermissionInCurrentSession($article->author_id)) : ?>
            <a href = 'session.php?action=editArticle&amp;categoryId=<?php echo $article->category_id.'&amp;articleId='.$article->article_id?>'>게시글 수정</a>
          <?php endif ?>
        </div>
      </div>
      
      <?php if($loadComment) include("templates/include/commentForm.php") ?>

      <p><a href="./session.php?location=<?php echo $location[0] ?>">게시판으로 돌아가기</a></p>

      
    </div>
  </div>

<?php include "templates/include/footer.php" ?>