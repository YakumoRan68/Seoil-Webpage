댓글 총 <?php echo $results['totalCommentRows'] ?> 개

<table>
  <?php foreach ($results['comments'] as $comment) { ?>
      <tr> <!-- TODO : 댓글부분 클릭하면 대댓글 입력창 뜨게 -->
        <td><?php echo $comment->commenter_id ?></td>
        <td><?php echo $comment->content ?></td>
        <td><?php echo date("Y-m-d H:i:s", $comment->reg_date) ?></td>
        <td><table><form action="session.php?action=deleteComment">
        <input type="hidden" name="articleId" value="<?php echo $results['article']->article_id ?>"/>
        <input type="hidden" name="categoryId" value="<?php echo $results['article']->category_id ?>"/>
        <input type="hidden" name="commentIndex" value="<?php echo $comment->comment_index ?>"/>
        <input type="submit" value="삭제">
        </form></table></td>
      </tr>
  <?php } ?>
</table>

<?php if(pageMetadata()[(int)$_GET['categoryId']]['allowAnnonymous'] ?? false) : ?>

<form action="session.php?action=newComment" method="post">
  <input type="hidden" name="articleId" value="<?php echo $results['article']->article_id ?>"/>
  <input type="hidden" name="categoryId" value="<?php echo $results['article']->category_id ?>"/>
  <input type="hidden" name="commenter_id" value="<?php echo $_SESSION['userid'] ?? "익명" ?>"/>
  <input type="hidden" name="reg_date" value="<?php echo date("Y-m-d H:i:s") ?>" />

  <ul>
    <li>
      <input readonly placeholder="<?php echo $_SESSION['userid'] ?? "익명" ?>" />
    </li>
    <li>
      <textarea name="content" required maxlength="100000" placeholder="댓글 입력" style="height: 5em;" ></textarea>
    </li>
  </ul>

  <div class="buttons">
    <input type="submit" name="writeComment" value="등록" />
  </div>
</form>

<?php endif ?>