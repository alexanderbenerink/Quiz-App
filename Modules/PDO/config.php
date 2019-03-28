<?php

define( 'DB_HOST', 'localhost' );
define( 'DB_NAME', 'nee' );
define( 'DB_CHAR', 'utf8mb4' );
define( 'DB_USER', 'loic' );
define( 'DB_PASS', '123' );

session_start();

require_once 'includes/db.class.php';
require_once 'includes/user.class.php';
require_once 'includes/question.class.php';
//require_once 'includes/result.class.php';
require_once 'includes/quiz.class.php';


function preprint_r( $arr = [] ) {
  echo '<pre>';
  print_r( $arr );
  echo '</pre>';
}

 ?>