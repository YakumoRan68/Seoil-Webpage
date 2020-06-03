<?php include "templates/include/header.php";?>
  <?php $article = $results['article'] ?>

  <h1 style="width: 75%;"><?php echo $article->title ?></h1>
  <div style="width: 75%;"><?php echo $article->content?></div>
  <p class="pubDate"><?php echo date('m d H', $article->pub_date)?>일에 게시되었습니다.</p>
  
  <?php if(pageMetadata()[(int)$article->category_id]['loadComments'] ?? false) include("templates/include/commentForm.php") ?>

  <?php $location = pageMetadata()[(int)$article->category_id][0]; ?>
  <p><a href="./session.php?location=<?php echo $location ?>">게시판으로 돌아가기</a></p>

  <?php if(hasPermissionInCurrentSession($article->author_id)) : ?>
    <a href = 'session.php?action=editArticle&amp;categoryId=<?php echo $article->category_id.'&amp;articleId='.$article->article_id?>'>게시글 수정</a>
  <?php endif ?>
<?php include "templates/include/footer.php" ?>