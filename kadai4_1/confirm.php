<?php
  // Start the session
  session_start();

  // Array for data to loop through
  $submission_data = array();

  // Define variables for completed values
  array_push($submission_data, $_POST['public_group_code']);
  array_push($submission_data, $_POST['zip_code_old']);
  array_push($submission_data, $_POST['zip_code']);
  array_push($submission_data, $_POST['prefecture_kana']);
  array_push($submission_data, $_POST['city_kana']);
  array_push($submission_data, $_POST['town_kana']);
  array_push($submission_data, $_POST['prefecture']);
  array_push($submission_data, $_POST['city']);
  array_push($submission_data, $_POST['town']);
  array_push($submission_data, $_POST['town_double_zip_code']);
  array_push($submission_data, $_POST['town_multi_address']);
  array_push($submission_data, $_POST['town_attach_district']);
  array_push($submission_data, $_POST['zip_code_multi_town']);
  array_push($submission_data, $_POST['update_check']);
  array_push($submission_data, $_POST['update_reason']);
  $_SESSION["submission_data"] = $submission_data;
  $comment_table_fields = $_SESSION["comment_table_fields"];
  $_SESSION["submitting"] = true;
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
  <title>テストページ</title>
  </head>
  <body>
      <h3>情報確認</h3>
      <button onclick="history.back();">Back</button></br>
      <form action="regist.php" method="POST">
        <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
          <?php
            for($x = 0; $x < sizeof($comment_table_fields); $x++) {
          ?>
          <tr>
            <?php
              print "<td width='200'>" . htmlspecialchars($comment_table_fields[$x], ENT_COMPAT, 'utf-8') . "</td>";
              print "<td width='400'>" . htmlspecialchars($submission_data[$x], ENT_COMPAT, 'utf-8') . "</td>";
            ?>
          </tr>
            <?php } ?>
        </table>
        <p>この内容で宜しいですか？
        <input type="submit" name="submit" class="button" value="はい" /> 
      </form>
  </body>
</html>