<?php if (isset($results['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

<?php if (isset($results['statusMessage'])) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

<div class = "page-name">
  <h1><?php echo getCategoryName($_GET['location'])[1] ?></h1>
</div>

<?php 
  $category_id = getCategoryKey($_GET['location']);
?>

<table class = "article-list">
  <thead><tr>
    <th>글 번호</th>
    <th>제목</th>
    <th>작성자</th>
    <th>작성일</th>
    <th>분류</th>
    <th>조회수</th>
  </tr></thead>
<tbody>
<?php foreach ($results['articles'] as $article) { ?>
  <tr onclick="location='session.php?action=viewArticle&amp;categoryId=<?php echo $article->category_id.'&amp;articleId='.$article->article_id ?>'">
    <td><?php echo $article->article_id ?></td>
    <td><?php echo htmlspecialchars($article->title)?></td>
    <td><?php echo $article->author_id ?></td>
    <td><?php echo date("Y-m-d H:i:s", $article->pub_date)?></td>
    <td><?php echo $article->category_id ?></td>
    <td><?php echo $article->views ?></td>
  </tr>
<?php } ?>
</tbody>
</table>

<?php if(canWriteArticle($category_id)) : ?>
  <a class="create-article" onClick="location='session.php?action=newArticle&amp;categoryId=<?php echo $category_id?>'">글 작성</a>
<?php endif ?>

<div class = "article-navigation">
  <div class = "article-paging"> <!-- TODO : 페이징 작업 -->
    <a href="#" class="page-move">첫 페이지</a>
    <a href="#" class="page-move">이전 페이지</a>
    <a href="#" class="num-now">1</a>
    <a href="#" class="num">2</a>
    <a href="#" class="num">3</a>
    <a href="#" class="num">4</a>
    <a href="#" class="num">5</a>
    <a href="#" class="page-move">다음 페이지</a>
    <a href="#" class="page-move">마지막 페이지</a>
  </div>
  

  <div class = "article-search">				
    <select name="language" >
      <option value="none">=== 선택 ===</option>
      <option value="titlename">제목</option>
      <option value="contentname">내용</option>
      <option value="person">글쓴이</option>
      <option value="titlecontent">제목+내용</option>
    </select>
    <input type="text" placeholder="검색어 입력">
    <button>검색</button>
  </div>
</div>

<p>총 <?php echo $results['totalArticleRows']?>개의 게시글<?php echo ($results['totalArticleRows'] != 1) ? '들' : '' ?>이 있습니다.</p>
<p><a href="./">홈페이지로 돌아가기</a></p>