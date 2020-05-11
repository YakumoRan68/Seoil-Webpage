<?php

require("config.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

switch ($action) {
  case 'login': login(); break;
  case 'logout': logout(); break;
  case 'register': register(); break;
  case 'newArticle': newArticle(); break;
  case 'editArticle': editArticle(); break;
  case 'deleteArticle': deleteArticle(); break;
  default : listArticles();
}

function login() {
  $results = array();
  $results['pageTitle'] = "Login | 서일대학교 커뮤니티 포털";

  if (!isset($_SESSION['userid'])) {
    if (isset($_POST['login'])) {
      $userid = $_POST['userid'];
      $password = $_POST['userpw'];

      if ($userid == ADMIN_USERNAME && $password == ADMIN_PASSWORD) {
        $_SESSION['userid'] = ADMIN_USERNAME;
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
          $_SESSION['userpw'] = $account['userpw'];

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
  unset($_SESSION['userpw']);
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
    require(TEMPLATE_PATH . "/admin/registrationForm.php");
  }
}

function newArticle() {
  $results = array();
  $results['pageTitle'] = "글 작성";
  $results['formAction'] = "newArticle";

  if (isset($_POST['saveChanges'])) {
    $article = new Article;
    $article->storeFormValues($_POST);
    $article->insert();
    header("Location: session.php?status=changesSaved");
  } elseif (isset($_POST['cancel'])) {
    header("Location: session.php");
  } else {
    $results['article'] = new Article;
    require(TEMPLATE_PATH . "/admin/editArticle.php");
  }
}

function editArticle() {
  $results = array();
  $results['pageTitle'] = "게시물 수정";
  $results['formAction'] = "editArticle";

  if (isset($_POST['saveChanges'])) {
    $article = Article::getById((int)$_POST['articleId']);
    if (!hasPermissionInCurrentSession($article->author_id)){
      error_page("noPermission");
      return;
    }

    $article->storeFormValues($_POST);
    $article->update();
    header("Location: session.php?status=changesSaved");
  } elseif (isset($_POST['cancel'])) {
    header("Location: session.php");
  } else {
    $results['article'] = Article::getById((int)$_GET['articleId']);
    require(TEMPLATE_PATH . "/admin/editArticle.php");
  }
}


function deleteArticle() {
  if (!$article = Article::getById((int)$_GET['articleId'])) {
    error_page("articleNotFound");
    return;
  } elseif(!hasPermissionInCurrentSession($article->author_id)) return error_page("noPermission");

  $article->delete();
  header("Location: session.php?status=articleDeleted");
}


function listArticles() {
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "모든 게시글";

  if (isset($_GET['status'])) {
    if ($_GET['status'] == "changesSaved") $results['statusMessage'] = "게시글이 저장되었습니다.";
    if ($_GET['status'] == "articleDeleted") $results['statusMessage'] = "게시글이 삭제되었습니다.";
  }

  require(TEMPLATE_PATH . "/admin/listArticles.php");
}

?>