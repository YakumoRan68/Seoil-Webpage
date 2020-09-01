<?php include "templates/include/header.php" ?>
<?php $article = $results['article'] ?>

<div class = "page-name" style ="margin-bottom : 5px">
  <h1><?php echo $results['pageTitle']?></h1>
  <hr>
</div>

<form class = "article-form" action="session.php?action=<?php echo $results['formAction']?>" method="post">
  <input type="hidden" name="articleId" value="<?php echo $results['article']->article_id ?>"/>
  <input type="hidden" name="categoryId" value="<?php echo $results['article']->category_id ?? $_GET['categoryId']?>"/>

<?php if (isset($results['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
  <fieldset>
    <ul>
      <li>
        <label for="form-label">글 제목</label><br>
        <input type="text" name="title" id="title" required autofocus maxlength="255"  placeholder="글 제목을 입력하세요."  value="<?php echo htmlspecialchars($results['article']->title)?>" />
      </li>
      <li>
        <label for="content">글 내용</label><br>
        <textarea name="content" id="content" required maxlength="65535" placeholder="글 내용을 입력하세요."><?php echo htmlspecialchars($results['article']->content)?></textarea>
      </li>
      <li>
        <label for="file_upload">첨부파일</label><br>
        <input type="file" class="file_select" placeholder="첨부파일을 선택하세요." />
      </li><hr>
      
      <li hidden>
        <label hidden for="pub_date">작성예약일</label>
        <input type="hidden" name="pub_date" id="pub_date" placeholder=<?php echo preg_replace("/ /", "&nbsp;", date("Y-m-d H:i:s"))?> maxlength="19" value="<?php echo $results['article']->pub_date ? date("Y-m-d H:i:s", $results['article']->pub_date): "" ?>" />
      </li>
    </ul>

    <div class="article-submit">
      <input type="submit" name="saveChanges" value="게시물 저장" />
      <input type="submit" formnovalidate name="cancel" value="취소" />
    </div>
  </fieldset>
</form>

<?php if ($results['article']->article_id){ ?>
<p><a href="session.php?action=deleteArticle&amp;categoryId=<?php echo $article->category_id.'&amp;articleId='.$article->article_id?>" onclick="return confirm('정말 이 게시물을 지우겠습니까?')">게시물 삭제</a></p>
<?php } ?>
<?php include "templates/include/footer.php" ?>