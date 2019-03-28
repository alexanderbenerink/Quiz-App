<?php 

class DB{

  private static $instance;
  private $pdo;

	public function __construct() {
    
    $opt  = array(
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => FALSE,
    );
    
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
    try{
      $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);  
    }
    catch(PDOExeption $e)
    {
      exit("Error");
    }
  }

  public static function getInstance()
  {
    if (self::$instance === null)
    {
      self::$instance = new self;
    }
    return self::$instance;
  }

  public function __call($method, $args)
  {
    return call_user_func_array(array($this->pdo, $method), $args);
  }

  public function run($sql, $args = [])
  {
    if (!$args)
    {
       return $this->query($sql);
    }
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($args);
    return $stmt;
  }
}

?>