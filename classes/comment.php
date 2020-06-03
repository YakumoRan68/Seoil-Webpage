<?php

class Comment {
  public $category_id = null;
  public $article_id = null;
  public $comment_index = null; //댓글 위치(4), 대댓글 깊이(2), 대댓글 순서(3)
  public $commenter_id = null;
  #public $password = null;
  public $content = null;
  public $reg_date = null;
  #public $admin_tag = null;

  public function __construct($data=array()) {
    if (isset($data['category_id'])) $this->category_id = $data['category_id'];
    if (isset($data['article_id'])) $this->article_id = (int)$data['article_id'];
    if (isset($data['comment_index'])) $this->comment_index = $data['comment_index'];
    if (isset($data['commenter_id'])) $this->commenter_id = $data['commenter_id'];
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

  public static function getListFromUID($article_id, $category_id) {
    $numCommentRows=50; //세션데이터에 추가;

    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, article_id, category_id, comment_index FROM comments WHERE category_id = :category_id AND article_id = :article_id
            ORDER BY comment_index ASC LIMIT :numRows"; #comment_index + 0

    $st = $conn->prepare($sql);
    $st->bindValue(":category_id", $category_id, PDO::PARAM_STR);
    $st->bindValue(":article_id", $article_id, PDO::PARAM_STR);
    $st->bindValue(":numRows", $numCommentRows, PDO::PARAM_INT);
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

  public function getNewCommentIndex($category_id, $article_id) {
    $list = Comment::getListFromUID($article_id, $category_id);

    return sprintf('%1$04d', (int)substr($list['results'][array_key_last($list['results'])]->comment_index ?? "0000", 0, 4) + 1)."00000";
  }

  public function insert($category_id, $article_id, $comment_index = null) {
    $comment_index = $comment_index ?? $this->getNewCommentIndex($category_id, $article_id);
    #error_log($comment_index);

    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "INSERT INTO comments(category_id, article_id, commenter_id, comment_index, content, reg_date) VALUES (:category_id, :article_id, :commenter_id, :comment_index, :content, :reg_date)";
    $st = $conn->prepare($sql);
    $st->bindValue(":category_id", $category_id, PDO::PARAM_STR);
    $st->bindValue(":article_id", $article_id, PDO::PARAM_INT);
    $st->bindValue(":commenter_id", $_SESSION['userid'] ?? "익명", PDO::PARAM_STR); //익명게시판 구현때 확인하기
    $st->bindValue(":comment_index", $comment_index, PDO::PARAM_STR);
    $st->bindValue(":content", $this->content, PDO::PARAM_STR);
    $st->bindValue(":reg_date", $this->reg_date, PDO::PARAM_INT);
    $st->debugDumpParams();

    $st->execute();

    $conn = null;
  }

  public function update() {
    if (is_null($this->article_id)) error_page("wrongUID");
   
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "UPDATE comments SET content=:content WHERE article_id = :article_id AND category_id = :category_id AND comment_index = :comment_index";
    $st = $conn->prepare($sql);
    $st->bindValue(":content", $this->content, PDO::PARAM_STR);
    $st->bindValue(":article_id", $this->article_id, PDO::PARAM_INT);
    $st->bindValue(":category_id", $this->category_id, PDO::PARAM_STR);
    $st->bindValue(":comment_index", $this->comment_index, PDO::PARAM_STR);
    $st->execute();
    #$st->debugDumpParams();

    $conn = null;
  }

  public function delete($category_id, $article_id, $comment_index) { 
    //대댓글은 댓글이 지워지면 모두 지워져야 함. https://lightcode.tistory.com/22
    if (is_null($this->article_id)) error_page("wrongUID");
    #elseif(!hasPermissionInCurrentSession($this->commenter_id)) return error_page("noPermission");

    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $st = $conn->prepare("DELETE FROM articles WHERE article_id = :article_id AND category_id = :category_id AND comment_index = :comment_index LIMIT 1");
    $st->bindValue(":category_id", category_id, PDO::PARAM_STR);
    $st->bindValue(":article_id", article_id, PDO::PARAM_INT);
    $st->bindValue(":comment_index", comment_index, PDO::PARAM_STR);
    $st->execute();

    $conn = null;
  }

  
}

?>