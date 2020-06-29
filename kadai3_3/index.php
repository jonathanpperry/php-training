<?php
  // Variable for number of rows
  $num_rows = 0;
  $num_cols = 15;

  $db_host        = 'localhost';
  $db_user        = 'root';
  $db_pass        = '';
  $db_database    = 'mc_kadai'; 
  $db_port        = '3306';

  $link = mysqli_connect($db_host, $db_user, $db_pass, $db_database, $db_port);

  /* check connection */
  if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
  }

  // Set UTF-8
  mysqli_set_charset($link, "utf8");

  /* Select queries return a resultset */
  $result = mysqli_query($link, "SELECT * FROM kadai_jonathan_ziplist");

  $comment_table_query = mysqli_query($link,
    "SHOW FULL COLUMNS FROM kadai_jonathan_ziplist");

  //declare arrays for saving properties
  $all_property = array();
  $title_array = array();
  $column_data = array();

  while ($row = mysqli_fetch_array($comment_table_query)) {
    array_push($title_array, $row["Comment"]);
  }

  while ($property = mysqli_fetch_field($result)) {
    //save field names to array to be used for fetching data
    array_push($all_property, $property->name);
  }

  //showing all data
  while ($row = mysqli_fetch_array($result)) {
    foreach ($all_property as $item) {
      if ($item == "town_double_zip_code" || $item == "town_multi_address" || $item == "town_attach_district" || $item == "zip_code_multi_town") {
        if ($row[$item] == 0) {
          array_push($column_data, "該当");
        }
        elseif ($row[$item] == 1) {
          array_push($column_data, "該当せず");
        } else {
          array_push($column_data, "不明");
        }
      } elseif ($item == "update_check") {
        if ($row[$item] == 0) {
          array_push($column_data, "変更なし");
        } elseif ($row[$item] == 1) {
          array_push($column_data, "変更あり");
        } elseif ($row[$item] == 2) {
          array_push($column_data, "廃止(廃止データのみ使用)");
        } else {
          array_push($column_data, "不明");
        }
      }
      elseif ($item == "update_reason") {
        if ($row[$item] == 0) {
          array_push($column_data, "変更なし");
        }
        elseif ($row[$item] == 1) {
          array_push($column_data, "市政・区政・町政・分区・政令指定都市施行");
        }
        elseif ($row[$item] == 2) {
          array_push($column_data, "住居表示の実施");
        }
        elseif ($row[$item] == 3) {
          array_push($column_data, "区画整理");
        }
        elseif ($row[$item] == 4) {
          array_push($column_data, "郵便区調整等");
        }
        elseif ($row[$item] == 5) {
          array_push($column_data, "訂正");
        }
        elseif ($row[$item] == 6) {
          array_push($column_data, "廃止(廃止データのみ使用)");
        }
        else {
          array_push($column_data, "不明");
        }
      }
      else {
        // Just display value from database
        array_push($column_data, htmlspecialchars($row[$item]));
      }
    }
    $num_rows++;
  }

  /* free result set */
  mysqli_free_result($result);

  /* free comments result set */
  mysqli_free_result($comment_table_query);
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
        for ($x = 0; $x < sizeof($column_data); $x++) {
          if ($x % $num_cols == 0) {
            print "<tr>" . "\n";
          }
          print "<td>" . $column_data[$x] . "</td>" . "\n";
          if ($x % $num_cols == ($num_rows-1)) {
            print "</tr>" . "\n";
          }
        }
      ?>
    </table>
  </body>
</html>
