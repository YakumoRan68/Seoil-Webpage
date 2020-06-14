<?php 
  include "templates/include/header.php";
  $article = $results['article'];
  $location = pageMetadata()[(int)$article->category_id]; 
  $loadComment = pageMetadata()[(int)$article->category_id]['loadComments'] ?? false
?>
  <div id = "container">
    <div class = "content-wrapper">
      <h1 class = "page-name"><?php echo $location[1] ?></h1> 
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
      
      <?php if($loadComment) : ?>
        <div class = "comment-wrapper">
          <table>
            <?php foreach ($results['comments'] as $comment) { ?>
                <tr class = "comment-header"> <!-- TODO : 댓글부분 클릭하면 대댓글 입력창 뜨게 -->
                  <td class = "comment-user-name"><?php echo $comment->commenter_id ?></td>
                  <td class = "comment-date"><?php echo date("m.d H:i:s", $comment->reg_date) ?></td>
                  <td><table><form action="session.php?action=deleteComment" method="post">
                    <input type="hidden" name="articleId" value="<?php echo $results['article']->article_id ?>"/>
                    <input type="hidden" name="categoryId" value="<?php echo $results['article']->category_id ?>"/>
                    <input type="hidden" name="commentIndex" value="<?php echo $comment->comment_index ?>"/>
                    <?php if(hasPermissionInCurrentSession($comment->commenter_id)) : ?>
                      <input type="submit" value="삭제">
                    <?php endif ?>
                  </form></table></td>
                </tr>
                <tr>
                  <td class = "comment-content-wrapper">
                    <div class = "comment-content"><?php echo $comment->content ?></div>
                  </td>
                </tr>
                <tr><td class = "comment-contour" colspan = 3></tr>
            <?php } ?>
          </table>

          <?php if(pageMetadata()[(int)$_GET['categoryId']]['allowAnnonymous'] ?? false) : ?>
            <form class = "comment-form-wrapper" action="session.php?action=newComment" method="post">
              <input type="hidden" name="articleId" value="<?php echo $results['article']->article_id ?>"/>
              <input type="hidden" name="categoryId" value="<?php echo $results['article']->category_id ?>"/>
              <input type="hidden" name="commenter_id" value="<?php echo $_SESSION['userid'] ?? "익명" ?>"/>
              <input type="hidden" name="reg_date" value="<?php echo date("Y-m-d H:i:s") ?>" />

              <ul>
                <li class = "comment-input-wrapper">
                  <textarea class="comment-input" name = "content" required maxlength="65535" 
                  placeholder="인터넷은 우리가 함께 만들어가는 소중한 공간입니다. 댓글 작성 시 타인에 대한 배려와 책임을 다해주세요." ></textarea>
                </li>
              </ul>

              <input class = "comment-submit" type="submit" name="writeComment" value="등록" />
            </form>
          <?php endif ?>
        </div>
      <?php endif ?>

      <p><a href="./session.php?location=<?php echo $location[0] ?>">게시판으로 돌아가기</a></p>

    </div>
  </div>

<?php include "templates/include/footer.php" ?>