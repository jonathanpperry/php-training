<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    function clear_session_fields() {
      $_SESSION["public_group_code"] = null;
      $_SESSION["zip_code_old"] = null;
      $_SESSION["zip_code"] = null;
      $_SESSION["prefecture_kana"] = null;
      $_SESSION["city_kana"] = null;
      $_SESSION["town_kana"] = null;
      $_SESSION["prefecture"] = null;
      $_SESSION["city"] = null;
      $_SESSION["town"] = null;
      $_SESSION["town_double_zip_code"] = null;
      $_SESSION["town_multi_address"] = null;
      $_SESSION["town_attach_district"] = null;
      $_SESSION["zip_code_multi_town"] = null;
      $_SESSION["update_check"] = null;
      $_SESSION["update_reason"] = null;    
    }

    // Start the session
    session_start();

    //declare arrays for saving properties
    $all_property = array();
    $title_array = array();
    $column_data = array();
  
    // number of rows/cols
    $num_rows = null;
    $num_cols = 15;

    $my_db = new MyDBControllerMySQL();
    // Connect again after insert if it occurred
    $my_db->connect();

    // Text to display regarding query
    $blue_success_text = '';
    $red_error_text = '';

    // Set if coming from submission
    $my_db->console_log("session submitted is" . $_SESSION["submitted"]);
    if ($_SESSION["submitted"] == true) {
      if ($_SESSION["submit_success"] == true) {
        $blue_success_text = "1行登録完了しました";
      } else {
        $red_error_text = "登録失敗しました(SQLerror文)";
      }
      $_SESSION["submitted"] = false;
    }

    $comment_table_query = 
      "SHOW FULL COLUMNS FROM kadai_jonathan_ziplist";
    /* Query for the rows data */
    $row_data_query = "SELECT * FROM kadai_jonathan_ziplist";
    $comment_table_fields = $my_db->query($comment_table_query, "mysqli_fetch_array_with_argument", "Comment");
    $postal_data = $my_db->query($row_data_query, "mysqli_fetch_array", null);
    
    // Set data to render in the view
    $column_data = setData($postal_data, $num_cols);

    // Close database connection
    $my_db->close();

    function setData($postal_data, $num_cols) : array
    {
      $column_data = array();
      $num_rows = sizeof($postal_data);
      //showing all data
      for ($x = 0; $x < $num_rows; $x++) {
        for ($y = 0; $y < $num_cols; $y++) {
          if ($y == 9 || $y == 10 || $y == 11 || $y == 12) {
            if ($postal_data[$x][$y] == 0) {
              array_push($column_data, "該当");
            } elseif ($postal_data[$x][$y] == 1) {
              array_push($column_data, "該当せず");
            } else {
              array_push($column_data, "不明");
            }
          } elseif ($y == 13) {
            if ($postal_data[$x][$y] == 0) {
              array_push($column_data, "変更なし");
            } elseif ($postal_data[$x][$y] == 1) {
              array_push($column_data, "変更あり");
            } elseif ($postal_data[$x][$y] == 2) {
              array_push($column_data, "廃止(廃止データのみ使用)");
            } else {
              array_push($column_data, "不明");
            }
          } elseif ($y == 14) {
            if ($postal_data[$x][$y] == 0) {
              array_push($column_data, "変更なし");
            } elseif ($postal_data[$x][$y] == 1) {
              array_push($column_data, "市政・区政・町政・分区・政令指定都市施行");
            } elseif ($postal_data[$x][$y] == 2) {
              array_push($column_data, "住居表示の実施");
            } elseif ($postal_data[$x][$y] == 3) {
              array_push($column_data, "区画整理");
            } elseif ($postal_data[$x][$y] == 4) {
              array_push($column_data, "郵便区調整等");
            } elseif ($postal_data[$x][$y] == 5) {
              array_push($column_data, "訂正");
            } elseif ($postal_data[$x][$y] == 6) {
              array_push($column_data, "廃止(廃止データのみ使用)");
            } else {
              array_push($column_data, "不明");
            }
          } else {
            // Just display value from database
            array_push($column_data, htmlspecialchars($postal_data[$x][$y]));
          }
        }
      }
      return $column_data;
    }
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
  <h2>課題4_1へようこそ</h2>
    <?php if(strlen($blue_success_text) > 0) {
      print "<p class='blue-success-text'>" . $blue_success_text . "</p>";
    } elseif(strlen($red_error_text) > 0) {
      print "<p class='red-error-text'>" . $red_error_text . "</p>";
    }
    ?>

    <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
      <tr>
        <?php
          foreach($comment_table_fields as $title_text) {
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
          if ($x % $num_cols == ($my_db->num_rows-1)) {
            print "</tr>" . "\n";
          }
        }
      ?>
    </table>
    <form action="input.php" method="GET">
      <input type="submit" name="submit" value="入力へ">
    </form>
  </body>
</html>
