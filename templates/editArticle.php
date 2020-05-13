<?php include "templates/include/header.php" ?>
  <?php $article = $results['article'] ?>
  <h1><?php echo $results['pageTitle']?></h1>

  <form action="session.php?action=<?php echo $results['formAction']?>" method="post">
    <input type="hidden" name="articleId" value="<?php echo $results['article']->article_id ?>"/>
    <input type="hidden" name="categoryId" value="<?php echo $results['article']->category_id ?>"/>

<?php if (isset($results['errorMessage'])) { ?>
    <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

    <ul>
      <li>
        <label for="title">게시글 제목</label>
        <input type="text" name="title" id="title" placeholder="게시물 제목을 입력하세요." required autofocus maxlength="255" value="<?php echo htmlspecialchars($results['article']->title)?>" />
      </li>
      <li>
        <label for="content">내용</label>
        <textarea name="content" id="content" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars($results['article']->content)?></textarea>
      </li>
      <li>
        <label for="pub_date">작성일</label>
        <input type="datetime" name="pub_date" id="pub_date" placeholder=<?php echo preg_replace("/ /", "&nbsp;", date("Y-m-d H:i:s"))?> maxlength="19" value="<?php echo $results['article']->pub_date ? date("Y-m-d H:i:s", $results['article']->pub_date): "" ?>" />
      </li>
    </ul>

    <div class="buttons">
      <input type="submit" name="saveChanges" value="게시물 저장" />
      <input type="submit" formnovalidate name="cancel" value="취소" />
    </div>
  </form>

<?php if ($results['article']->article_id){ ?>
  <p><a href="session.php?action=deleteArticle&amp;categoryId=<?php echo $article->category_id.'&amp;articleId='.$article->article_id?>" onclick="return confirm('정말 이 게시물을 지우겠습니까?')">게시물 삭제</a></p>
<?php } ?>
<?php include "templates/include/footer.php" ?>