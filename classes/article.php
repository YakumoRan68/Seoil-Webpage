<?php

class Article {
  public $article_id = null;
  public $author_id = null;
  public $category_id = null;
  public $title = null;
  public $content = null;
  public $reg_date = null;
  public $pub_date = null;
  public $views = null;

  public function __construct($data=array()) {
    if (isset($data['article_id'])) $this->article_id = (int)$data['article_id'];
    if (isset($data['author_id'])) $this->author_id = (int)$data['author_id'];
    if (isset($data['category_id'])) $this->category_id = (int)$data['category_id'];
    if (isset($data['title'])) $this->title = preg_replace('/[^\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}0-9a-zA-Z\s]/u', "", $data['title']);
    if (isset($data['content'])) $this->content = $data['content']; //TODO : Rich Text Editor
    if (isset($data['reg_date'])) $this->reg_date = (int)$data['reg_date'];
    if (isset($data['pub_date'])) $this->pub_date = (int)$data['pub_date'];
    if (isset($data['views'])) $this->views = (int)$data['views'];
  }

  public function storeFormValues ($params ) {
    $this->__construct($params);
    
    if (isset($params['pub_date'])) {
      $this->pub_date = $params['pub_date'] == "" ? time() : strtotime($params['pub_date']);
    }
  }

  public static function getById($article_id ) {
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "SELECT *, pub_date AS pub_date FROM articles WHERE article_id = :article_id";
    $st = $conn->prepare($sql);
    $st->bindValue(":article_id", $article_id, PDO::PARAM_INT);
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ($row ) return new Article($row );
    else return array(); #TODO : error.php에 코드로 작성해서 전용 에러 객체로 반환.
  }

  public static function getList($numRows=1000000 ) {
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, article_id AS id FROM articles
            ORDER BY id DESC LIMIT :numRows";

    $st = $conn->prepare($sql);
    $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
    $st->execute();
    $list = array();

    while ($row = $st->fetch()) {
      $article = new Article($row );
      $list[] = $article;
    }

    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query($sql)->fetch();
    $conn = null;

    return array("results" => $list, "totalRows" => $totalRows[0]);
  }

  public function view() {
    if ( is_null($this->article_id)) trigger_error ( "Article::view(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
    
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "UPDATE articles SET views = views + 1 where article_id = :article_id";
    $st = $conn->prepare ($sql );
    $st->bindValue(":article_id", $this->article_id, PDO::PARAM_INT);
    $st->execute();

    $conn = null;
  }

  public function insert() {
    if ( !is_null($this->article_id)) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID property set.", E_USER_ERROR );

    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO articles (title, content, pub_date) VALUES (:title, :content, :pub_date)";
    $st = $conn->prepare ($sql );
    $st->bindValue(":pub_date", $this->pub_date, PDO::PARAM_INT);
    $st->bindValue(":title", $this->title, PDO::PARAM_STR);
    $st->bindValue(":content", $this->content, PDO::PARAM_STR);
    $st->execute();
    $this->article_id = $conn->lastInsertId();
    $conn = null;
  }

  public function update() {
    if ( is_null($this->article_id)) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
   
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE articles SET pub_date=:pub_date, title=:title, content=:content WHERE article_id = :article_id";
    $st = $conn->prepare ($sql );
    $st->bindValue(":pub_date", $this->pub_date, PDO::PARAM_INT);
    $st->bindValue(":title", $this->title, PDO::PARAM_STR);
    $st->bindValue(":content", $this->content, PDO::PARAM_STR);
    $st->bindValue(":article_id", $this->article_id, PDO::PARAM_INT);
    $st->execute();
    #$st->debugDumpParams();

    $conn = null;
  }

  public function delete() {
    if ( is_null($this->article_id)) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM articles WHERE article_id = :article_id LIMIT 1" );
    $st->bindValue( ":article_id", $this->article_id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }
}

?>