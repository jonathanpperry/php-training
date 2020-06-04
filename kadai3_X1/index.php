<?php
    require_once 'MyDBControllerMySQL.class.php';
    $my_db = new MyDBControllerMySQL();
    $my_db->connect();
    $my_db->query();
    $data_to_display = $my_db->all_property;
    $my_db->close();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
  </head>
  <body>
    <h2>課題3_X1へようこそ</h2>
    <ul>
    <?php
        foreach ($data_to_display as $item) {
          print "<li>" . $item . "</li>" . "\n";
        }
    ?>
    </ul>
  </body>
</html>