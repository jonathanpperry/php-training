<?php
  if (isset($_GET['fullname'], $_GET['gender'])) {
    $fullname = $_GET['fullname'];
    $gender = $_GET['gender'];  
  } else {
    $gender = 1;
  }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
  </head>
  <body>
    <h2>課題1.2_3へようこそ</h2>
    <form action="confirm.php" method="GET">
    名前: <input type="text" name="fullname" id="fullname" value="<?php print htmlspecialchars_decode(htmlspecialchars($fullname, ENT_QUOTES)); ?>"><br />
    <label for="gender">性別:</label>
    <select name="gender" id="gender" size="1">
      <option value="1" selected <?php echo ($gender == 1) ? "selected" : ""; ?>>男</option>
      <option value="2" <?php echo ($gender == 2) ? "selected" : ""; ?>>女</option>
      <option value="0" <?php echo ($gender == 0) ? "selected" : ""; ?>>答えない</option>
    </select><br />
    <input type="submit" name="submit">
    </form>
  </body>
</html>