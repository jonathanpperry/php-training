<?php
    require_once '../lib/MyDBControllerMySQL.class.php';

    // Start the session
    session_start();

    $table_name = "kadai_jonathan_ziplist";

    $publicGroupCode = $_GET['public_group_code'];
    $zipCodeOld = $_GET['zip_code_old'];
    $zipCode = $_GET['zip_code'];

    $my_db = new MyDBControllerMySQL();
    // Connect again after insert if it occurred
    $my_db->connect();

    $my_db->console_log($publicGroupCode);

    // Close database connection
    $my_db->close();

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
    <style>
      .blue-success-text {
        color: blue;
      }
      .red-error-text {
        color:red;
      }
    </style>
  </head>
  <body>
  <h3>上書きページ</h3>
  </body>
</html>