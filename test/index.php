<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    $my_db = new MyDBControllerMySQL();
    $my_db->connect();
    $my_db->query();
    $column_data = $my_db->column_data;
    $title_array = $my_db->title_array;
    $my_db->close();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
  </head>
  <body>
  <h2>課題3_3へようこそ</h2>
    <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
      <tr>
        <?php
          foreach($title_array as $title_text) {
            print "<th>" . $title_text . "</th>" . "\n";
          }
        ?>
      </tr>
      <br />
      <?php
        for ($x = 0; $x <= sizeof($column_data); $x++) {
          if ($x % $my_db->num_cols == 0) {
            print "<tr>" . "\n";
          }
          print "<td>" . $column_data[$x] . "</td>" . "\n";
          if ($x % $my_db->num_cols == ($my_db->num_rows-1)) {
            print "</tr>" . "\n";
          }
        }
      ?>
    </table>
  </body>
</html>