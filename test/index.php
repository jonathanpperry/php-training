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

  $all_property = array();  //declare an array for saving property

  //showing property
  $table_data .= '<table style="width:100%" border="1" cellpadding="5" cellspacing="0">';
  $table_data .= '<tr class="data-heading">';  //initialize table tag
  $property = mysqli_fetch_field($result);
  console_log("property is: " . $property);
  while ($property = mysqli_fetch_field($result)) {
    if ($property->name == "public_group_code") {
      $table_data .= '<td>' . "全国地方公共団体コード" . '</td>' . "\n";
    }
    elseif ($property->name == "zip_code_old") {
      $table_data .= '<td>' . "旧郵便番号" . '</td>' . "\n";
    }
    elseif ($property->name == "zip_code") {
      $table_data .= '<td>' . "郵便番号" . '</td>' . "\n";
    }
    elseif ($property->name == "prefecture_kana") {
      $table_data .= '<td>' . "都道府県名(半角カタカナ)" . '</td>' . "\n";
    }
    elseif ($property->name == "city_kana") {
      $table_data .= '<td>' . "市区町村名(半角カタカナ)" . '</td>' . "\n";
    }
    elseif ($property->name == "town_kana") {
      $table_data .= '<td>' . "町域名(半角カタカナ)" . '</td>' . "\n";
    }
    elseif ($property->name == "prefecture") {
      $table_data .= '<td>' . "都道府県名(漢字)" . '</td>' . "\n";
    }
    elseif ($property->name == "city") {
      $table_data .= '<td>' . "市区町村名(漢字)" . '</td>' . "\n";
    }
    elseif ($property->name == "town") {
      $table_data .= '<td>' . "町域名(漢字)" . '</td>' . "\n";
    }
    elseif ($property->name == "town_double_zip_code") {
      $table_data .= '<td>' . "一町域で複数の郵便番号か" . '</td>' . "\n";
    }
    elseif ($property->name == "town_multi_address") {
      $table_data .= '<td>' . "小字毎に番地が起番されている町域か" . '</td>' . "\n";
    }
    elseif ($property->name == "town_attach_district") {
      $table_data .= '<td>' . "丁目を有する町域名か" . '</td>' . "\n";
    }
    elseif ($property->name == "zip_code_multi_town") {
      $table_data .= '<td>' . "一郵便番号で複数の町域か" . '</td>' . "\n";
    }
    elseif ($property->name == "update_check") {
      $table_data .= '<td>' . "更新確認" . '</td>' . "\n";
    }
    elseif ($property->name == "update_reason") {
      $table_data .= '<td>' . "更新理由" . '</td>' . "\n";
    }
    //save it to array
    array_push($all_property, $property->name);
  }
  $table_data .= '</tr>' . "\n"; //end tr tag
  
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
  $table_data .= "</table>" . "\n";

  /* free result set */
  mysqli_free_result($result);

?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
  </head>
  <body>
    <h2>課題3_3へようこそ</h2>
    <?php print $table_data; ?>
  </body>
</html>
