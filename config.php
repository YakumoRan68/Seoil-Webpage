<?php
    ini_set( "display_errors", true );
    date_default_timezone_set( "Asia/Seoul" );  // http://www.php.net/manual/en/timezones.php
    define( "DB_DSN", "mysql:host=localhost;dbname=cms" );
    define( "DB_USERNAME", "seoil_db" );
    define( "DB_PASSWORD", "VZXxmKXUH03T9Jmq" );
    define( "CLASS_PATH", "classes" );
    define( "TEMPLATE_PATH", "templates" );
    define( "HOMEPAGE_NUM_ARTICLES", 5 );
    define( "ADMIN_USERNAME", "admin" );
    define( "ADMIN_PASSWORD", "fCyhaxvqYsR5XcP9" );
    require( CLASS_PATH . "/article.php" );

    function handleException( $exception ) {
      echo "Sorry, a problem occurred. Please try later.";
      error_log( $exception->getMessage() );
    }

    set_exception_handler( 'handleException' );
?>