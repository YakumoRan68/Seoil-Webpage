<?php

class Comment {
  public $category_id = null;
  public $article_id = null;
  public $comment_index = null; //댓글 위치(4), 
  public $commenter_id = null;
  #public $password = null;
  public $content = null;
  public $reg_date = null;
  #public $admin_tag = null;

  public function __construct($data=array()) {
    if (isset($data['category_id'])) $this->category_id = $data['category_id'];
    if (isset($data['article_id'])) $this->article_id = (int)$data['article_id'];
    if (isset($data['comment_index'])) $this->author_id = $data['comment_index'];
    if (isset($data['commenter_id'])) $this->author_id = $data['commenter_id'];
    #if (isset($data['password'])) $this->password = $data['password'];
    if (isset($data['content'])) $this->content = $data['content']; //TODO : Rich Text Editor
    if (isset($data['reg_date'])) $this->reg_date = (int)$data['reg_date'];
    #if (isset($data['admin_tag'])) $this->admin_tag = $data['admin_tag'];
  }

  public function storeFormValues ($params) {
    $this->__construct($params);
    
    if (isset($params['reg_date'])) {
      $this->reg_date = $params['reg_date'] == "" ? time() : strtotime($params['reg_date']);
    }
  }

  public static function getListFromUID($article_id, $category_id = "000") {
    $numCommentRows=10; //세션데이터에 추가;

    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, article_id, category_id, comment_index FROM comments WHERE category_id = :category_id AND article_id = :article_id
            ORDER BY comment_index DESC LIMIT :numRows";

    $st = $conn->prepare($sql);
    $st->bindValue(":category_id", $category_id, PDO::PARAM_STR);
    $st->bindValue(":article_id", $article_id, PDO::PARAM_STR);
    $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
    $st->execute();
    $list = array();

    while ($row = $st->fetch()) {
      $comment = new Comment($row);
      $list[] = $comment;
    }

    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query($sql)->fetch();

    $conn = null;

    return array("results" => $list, "totalRows" => $totalRows[0]);
  }

  public function insert($category_id) {
    if (!is_null($this->article_id)) error_page("wrongUID");

    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "INSERT INTO articles (title, content, pub_date, author_id) VALUES (:title, :content, :pub_date, :author_id)";
    $st = $conn->prepare($sql);
    $st->bindValue(":title", $this->title, PDO::PARAM_STR);
    $st->bindValue(":pub_date", $this->pub_date, PDO::PARAM_INT);
    $st->bindValue(":content", $this->content, PDO::PARAM_STR);
    $st->bindValue(":author_id", $_SESSION['userid'], PDO::PARAM_STR); //익명게시판 구현때 확인하기
    $st->bindValue(":category_id", $category_id, PDO::PARAM_STR);
    $st->execute();
    $this->article_id = $conn->lastInsertId();

    $conn = null;
  }

  public function update() {
    if (is_null($this->article_id)) error_page("wrongUID");
   
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "UPDATE articles SET pub_date=:pub_date, title=:title, content=:content WHERE article_id = :article_id AND category_id = :category_id";
    $st = $conn->prepare($sql);
    $st->bindValue(":title", $this->title, PDO::PARAM_STR);
    $st->bindValue(":pub_date", $this->pub_date, PDO::PARAM_INT);
    $st->bindValue(":content", $this->content, PDO::PARAM_STR);
    $st->bindValue(":article_id", $this->article_id, PDO::PARAM_INT);
    $st->bindValue(":category_id", $this->category_id, PDO::PARAM_STR);
    $st->execute();
    #$st->debugDumpParams();

    $conn = null;
  }

  public function delete() {
    if (is_null($this->article_id)) error_page("wrongUID");
    elseif(!hasPermissionInCurrentSession($this->author_id)) return error_page("noPermission");

    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $st = $conn->prepare("DELETE FROM articles WHERE article_id = :article_id AND category_id = :category_id LIMIT 1");
    $st->bindValue(":article_id", $this->article_id, PDO::PARAM_INT);
    $st->bindValue(":category_id", $this->category_id, PDO::PARAM_STR);
    $st->execute();

    $conn = null;
  }

  
}

?>