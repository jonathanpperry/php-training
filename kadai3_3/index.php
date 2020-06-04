<?php
    function console_log( $data ){
      echo '<script>';
      echo 'console.log('. json_encode( $data ) .')';
      echo '</script>';
  }

  $table_data = '';

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

  while ($row = mysqli_fetch_array($comment_table_query)) {
    array_push($title_array, $row["Comment"]);
  }

  while ($property = mysqli_fetch_field($result)) {
    //save field names to array to be used for fetching data
    array_push($all_property, $property->name);
  }

  //showing all data
  while ($row = mysqli_fetch_array($result)) {
    $table_data .= "<tr>";
    foreach ($all_property as $item) {
      if ($item == "town_double_zip_code" || $item == "town_multi_address" || $item == "town_attach_district" || $item == "zip_code_multi_town") {
        if ($row[$item] == 0) {
          $table_data .= '<td>' . "該当" . '</td>';
        }
        elseif ($row[$item] == 1) {
          $table_data .= '<td>' . "該当せず" . '</td>';
        } else {
          $table_data .= '<td>' . "不明" . '</td>';
        }
        $table_data .= "\n";
      } elseif ($item == "update_check") {
        if ($row[$item] == 0) {
          $table_data .= '<td>' . "変更なし" . '</td>';
        } elseif ($row[$item] == 1) {
          $table_data .= '<td>' . "変更あり" . '</td>';
        } else {
          $table_data .= '<td>' . "廃止(廃止データのみ使用)" . '</td>';
        }
        $table_data .= "\n";
      }
      elseif ($item == "update_reason") {
        if ($row[$item] == 0) {
          $table_data .= '<td>' . "変更なし" . '</td>';
        }
        elseif ($row[$item] == 1) {
          $table_data .= '<td>' . "市政・区政・町政・分区・政令指定都市施行" . '</td>';
        }
        elseif ($row[$item] == 2) {
          $table_data .= '<td>' . "住居表示の実施" . '</td>';
        }
        elseif ($row[$item] == 3) {
          $table_data .= '<td>' . "区画整理" . '</td>';
        }
        elseif ($row[$item] == 4) {
          $table_data .= '<td>' . "郵便区調整等" . '</td>';
        }
        elseif ($row[$item] == 5) {
          $table_data .= '<td>' . "訂正" . '</td>';
        }
        elseif ($row[$item] == 6) {
          $table_data .= '<td>' . "廃止(廃止データのみ使用)" . '</td>';
        }
        else {
          $table_data .= '<td>' . "不明" . '</td>';
        }
        $table_data .= "\n";
      }
      else {
        // Just display value from database
        $table_data .= '<td>' . htmlspecialchars($row[$item]) . '</td>';
        $table_data .= "\n";
      }
    }
    $table_data .= '</tr>' . "\n";
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
            print "<th>" . $title_text . "</th>";
          }
          ?>
      </tr>
      <br />
      <?php
        print $table_data;
      ?>
    </table>
  </body>
</html>
