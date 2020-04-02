<?php

/**
 * Class to handle articles
 */

static $str_filter = "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/";

class Article {
  public $article_id = null;
  public $author_id = null;
  public $title = null;
  public $content = null;
  public $reg_date = null;
  public $pub_date = null;
  public $views = null;


  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $data=array() ) {
    if ( isset( $data['article_id'] ) ) $this->article_id = (int) $data['article_id'];
    if ( isset( $data['author_id'] ) ) $this->author_id = (int) $data['author_id'];
    if ( isset( $data['category_id'] ) ) $this->category_id = (int) $data['category_id'];
    if ( isset( $data['title'] ) ) $this->title = preg_replace ( $str_filter, "", $data['title'] );
    if ( isset( $data['content'] ) ) $this->content = $data['content']; //TODO : Rich Text Editor
    if ( isset( $data['reg_date'] ) ) $this->reg_date = (int) $data['pub_date'];
    if ( isset( $data['pub_date'] ) ) $this->pub_date = (int) $data['pub_date'];
    if ( isset( $data['views'] ) ) $this->views = (int) $data['views'];
  }


  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */

  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );

    // Parse and store the publication date
    if ( isset($params['pub_date']) ) {
      $pub_date = explode ( '-', $params['pub_date'] );

      if ( count($pub_date) == 3 ) {
        list ( $y, $m, $d ) = $pub_date;
        $this->pub_date = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }


  /**
  * Returns an Article object matching the given article ID
  *
  * @param int The article ID
  * @return Article|false The article object, or false if the record was not found or there was a problem
  */

  public static function getById( $article_id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(pub_date) AS pub_date FROM articles WHERE article_id = :article_id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":article_id", $article_id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Article( $row );
  }


  /**
  * Returns all (or a range of) Article objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
  */

  public static function getList( $numRows=1000000 ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(pub_date) AS pub_date FROM articles
            ORDER BY pub_date DESC LIMIT :numRows";

    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $article = new Article( $row );
      $list[] = $article;
    }

    // Now get the total number of articles that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Article object into the database, and sets its ID property.
  */

  public function insert() {

    if ( !is_null( $this->article_id ) ) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->article_id).", E_USER_ERROR );

    // Insert the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO articles ( pub_date, title, summary, content ) VALUES ( FROM_UNIXTIME(:pub_date), :title, :content )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":pub_date", $this->pub_date, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    //$st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->execute();
    $this->article_id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Article object in the database.
  */

  public function update() {

    if ( is_null( $this->article_id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE articles SET pub_date=FROM_UNIXTIME(:pub_date), title=:title, summary=:summary, content=:content WHERE article_id = :article_id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":pub_date", $this->pub_date, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    //$st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->bindValue( ":article_id", $this->article_id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Article object from the database.
  */

  public function delete() {

    // Does the Article object have an ID?
    if ( is_null( $this->article_id ) ) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM articles WHERE article_id = :article_id LIMIT 1" );
    $st->bindValue( ":article_id", $this->article_id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>