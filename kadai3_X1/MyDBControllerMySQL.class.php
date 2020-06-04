<?php
class MyDBControllerMySQL
{
  //------------
  // 属性
  //------------
  var $db;      // DB接続オブジェクト
  var $error;   // エラーメッセージ(あると親切)

  var $db_host        = 'localhost';
  var $db_user        = 'root';
  var $db_pass        = '';
  var $db_database    = 'mc_kadai'; 
  var $db_port        = '3306';

  //declare arrays for saving properties
  var $all_property = array();


  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

  //------------
  // 操作
  //------------
  // コンストラクタ(DB接続)
  function __construct() {
  }

  // デストラクタ(DB切断)
  function __destruct() {
    print "Destroying " . __CLASS__ . "\n";
  }

  // 接続
  function connect() { 
    $this->db = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_database);
    if (!$this->db) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      exit;
    }
  
    $successString = "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
    $successString .= "Host information: " . mysqli_get_host_info($this->db) . PHP_EOL;
    
    // Log the success string
    $this->console_log($successString);

   }

  // 切断
  function close(  ) {
    // Close the DB connection
    mysqli_close($this->db);
  }

  // SQL実行
  function query () {
    /* Select queries return a resultset */
    $result = mysqli_query($this->db, "SELECT * FROM kadai_jonathan_ziplist");

    while ($property = mysqli_fetch_field($result)) {
      //save field names to array to be used for fetching data
      array_push($this->all_property, $property->name);
    }  
  }
}
?>