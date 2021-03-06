<?php

require("config.php");

$action = $_GET['action'] ?? "";
$userid = $_SESSION['userid'] ?? "";

switch ($action) {
  case 'login': login(); break;
  case 'logout': logout(); break;
  case 'register': register(); break;
  case 'newArticle': newArticle(); break;
  case 'editArticle': editArticle(); break;
  case 'viewArticle': viewArticle(); break;
  case 'newComment': newComment(); break;
  case 'deleteArticle': deleteArticle(); break;
  case 'deleteComment': deleteComment(); break;
  default : loadPage();
}

function login() {
  $results = array();
  $results['pageTitle'] = "Login | 서뮤니티";

  if (!isset($_SESSION['userid'])) {
    if (isset($_POST['login'])) {
      $userid = $_POST['userid'];
      $password = $_POST['userpw'];

      if ($userid == ADMIN_USERNAME && $password == ADMIN_PASSWORD) {
        $_SESSION['userid'] = ADMIN_USERNAME;
        $_SESSION['username'] = ADMIN_USERNAME;
        header("Location: session.php");
      } else {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM accounts WHERE userid=:userid";
        $st = $conn->prepare ($sql);
        $st->bindValue(":userid", $userid, PDO::PARAM_STR);
        $st->execute();
        $account = $st->fetch();

        $conn = null;

        if (password_verify($password, $account['userpw'])) {
          $_SESSION['userid'] = $userid;
          $_SESSION['username'] = $account['realname'];
          header("Location: session.php");
        } else {
          error_page("wrongAccount");
        }
      }
    } 
  } else {
    error_page("alreadyInSession");
  }
}

function logout() {
  unset($_SESSION['userid']);
  unset($_SESSION['username']);
  unset($_SESSION['location']);
  session_destroy();

  header("Location: session.php");
}

function register() {
  if (isset($_POST['register'])) {
    $userid = $_POST['userid'];
    $userpw = password_hash($_POST['userpw'], PASSWORD_DEFAULT);
    $realname = $_POST['realname'];
    $email = $_POST['email'].'@'.$_POST['emadress'];

    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "INSERT INTO accounts(userid, userpw, realname, email) VALUES (:userid, :userpw, :realname, :email)";
    $st = $conn->prepare($sql);
    $st->bindValue(":userid", $userid, PDO::PARAM_STR);
    $st->bindValue(":userpw", $userpw, PDO::PARAM_STR);
    $st->bindValue(":realname", $realname, PDO::PARAM_STR);
    $st->bindValue(":email", $email, PDO::PARAM_STR);
    $st->execute();

    $conn = null;
    alert("회원가입이 완료되었습니다. 가입한 계정으로 로그인 해주세요."); //TODO : 계정 인증절차(메일서버 구축)
    header("Location: session.php");
  } else {
    require(TEMPLATE_PATH . "/contents/registrationForm.php");
  }
}

function viewArticle() {
  if (!isset($_GET["articleId"]) || !isset($_GET['categoryId'])) return error_page("articleNotFound");

  $cnum = (int)$_GET['categoryId'];
  $results = array();
  $results['article'] = Article::getByUID((int)$_GET["articleId"], $_GET['categoryId']);

  if (!empty($results['article'])) $results['article']->view();
  else error_page("articleNotFound");

  $results['pageTitle'] = $results['article']->title . " | 서뮤니티";

  if(pageMetadata()[$cnum]['loadComments'] ?? false) {
    $article_ID = $_GET['articleId'];

    $data = Comment::getListFromUID($article_ID, getCategoryKey($cnum));
    $results['comments'] = $data['results'];
    $results['totalCommentRows'] = $data['totalRows'];
  }

  require(TEMPLATE_PATH . "/viewArticle.php");
}

function newComment() {
  if (isset($_POST['writeComment'])) {
    $comment = new Comment;
    $comment->storeFormValues($_POST);
    $comment->insert($_POST['categoryId'], $_POST['articleId']);
    goPage(array("action"=>"viewArticle", "categoryId"=>$_POST['categoryId'], "articleId"=>$_POST['articleId']));
  }
}

function deleteComment() {
  if (!$comment = Comment::getListFromUID((int)$_POST['articleId'], $_POST['categoryId'])) return error_page("commentsNotFound");
  elseif(!hasPermissionInCurrentSession($comment->commenter_id)) return error_page("noPermission");

  $comment->delete($_POST['categoryId'], (int)$_POST['articleId'], $_POST['commentIndex']);
  goPage(array("action"=>"viewArticle", "categoryId"=>$_POST['categoryId'], "articleId"=>$_POST['articleId']));
}

function newArticle() {
  $results = array();
  $results['pageTitle'] = "글 작성";
  $results['formAction'] = "newArticle";

  if (isset($_POST['saveChanges'])) {
    $article = new Article;
    $article->storeFormValues($_POST);
    foreach($_POST as $k => $v) {
      error_log($k.",".$v);
    }
    $article->insert($_POST['categoryId']);
    goPage(array("status"=>"changesSaved", "location"=>getFileName($_POST['categoryId'])));
  } elseif (isset($_POST['cancel'])) {
    goPage(array("location"=>getFileName($_POST['categoryId'])));
  } else {
    $results['article'] = new Article;
    require(TEMPLATE_PATH . "/editArticle.php");
  }
}

function editArticle() {
  $results = array();
  $results['pageTitle'] = "게시물 수정";
  $results['formAction'] = "editArticle";

  if (isset($_POST['saveChanges'])) {
    $article = Article::getByUID((int)$_POST['articleId'], $_POST['categoryId']);
    if (!hasPermissionInCurrentSession($article->author_id)){
      return error_page("noPermission");
    }

    $article->storeFormValues($_POST);
    $article->update();
    goPage(array("status"=>"changesSaved", "location"=>getFileName($_POST['categoryId'])));
  } elseif (isset($_POST['cancel'])) {
    goPage(array("location"=>getFileName($_POST['categoryId'])));
  } else {
    $results['article'] = Article::getByUID((int)$_GET['articleId'], $_GET['categoryId']);
    require(TEMPLATE_PATH . "/editArticle.php");
  }
}

function deleteArticle() {
  if (!$article = Article::getByUID((int)$_GET['articleId'], $_GET['categoryId'])) return error_page("articleNotFound");
  elseif(!hasPermissionInCurrentSession($article->author_id)) return error_page("noPermission");

  $article->delete();
  goPage(array("status"=>"articleDeleted", "location"=>getFileName($_GET['categoryId'])));
}

function loadPage() {
  $pMd = pageMetadata();
  $pagename = $_GET['location'] ?? "homepage";
  $cnum = (int)getCategoryKey($pagename);
  $results = array();
  $results['pageTitle'] = $pMd[$cnum][1];

  if($pagename == "homepage") {
    foreach(ARTICLES_LOAD_FOR_HOMEPAGE as $k => $v) {
      $key = getCategoryKey($v);
      $data = Article::getList($key);
      $results[$k]['articles'] = $data['results'];
      $results[$k]['key'] = $key;
    }
  } elseif($pMd[$cnum]['loadArticles'] ?? false) {
    $data = Article::getList(getCategoryKey($cnum));
    $results['articles'] = $data['results'];
    $results['totalArticleRows'] = $data['totalRows'];

    if (isset($_GET['status'])) {
      if ($_GET['status'] == "changesSaved") $results['statusMessage'] = "게시글이 저장되었습니다.";
      if ($_GET['status'] == "articleDeleted") $results['statusMessage'] = "게시글이 삭제되었습니다.";
    }
  }

  try {
    require(TEMPLATE_PATH."/contents/".$pagename.".php");
  } catch(exception $e) {
    require(TEMPLATE_PATH."/contents/test.php");
  }
}

?>