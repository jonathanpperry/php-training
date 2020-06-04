<?php
  $fullname = $_GET['fullname'];
  $gender = ($_GET['gender']);
  $suffix = '';
  if ($gender == 0) {
    $suffix = "さん";
  } else if ($gender == 1) {
    $suffix = "君";
  }
  // It's 2 for woman
  else {
    $suffix = "ちゃん";
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <title>テストページ</title>
</head>
<body>
    <h3>情報確認</h3>
    <a href="index.php?fullname=<?php echo urlencode(htmlspecialchars($fullname, ENT_QUOTES)) ?>&gender=<?php echo urlencode(htmlspecialchars($gender, ENT_QUOTES)) ?>">戻る</a>
      <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
          <td width="200">名前</td>
          <td><p><?php echo htmlspecialchars($fullname . ' ' . $suffix, ENT_QUOTES, 'utf-8'); ?></p></td>
          <input type="hidden" name="fullname" id="fullname" value="<?php echo htmlentities($fullname); ?>" readonly />
        </tr>
      </table>
</body>
</html>