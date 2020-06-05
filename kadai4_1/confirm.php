<?php
    $first = ($_POST['fname']);
    $last = ($_POST['lname']);
    $password = ($_POST['password']);
    $gender = ($_POST['gender']);
    if ($_POST['receiveemails'] == "yes") {
      $receiveEmails = true;
    } else {
      $receiveEmails = false;
    }
    $password = ($_POST['password']);
    $fileName = ($_POST['fileName']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>テストページ</title>
</head>
<body>
    <h3>情報確認</h3>
    <button onclick="history.back();">Back</button></br>
    <form action="complete.php" method="GET">
      <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
          <td width="200">名前</td>
          <td width="400"><?php print htmlspecialchars($first, ENT_COMPAT, 'utf-8'); ?></td>
          <input type="hidden" name="fname" id="fname" value="<?php echo htmlentities($first); ?>" readonly />
        </tr>
        <tr>
          <td>名字</td>
          <td width="400"><?php print htmlspecialchars($last, ENT_COMPAT, 'utf-8'); ?></td>
          <input type="hidden" name="lname" id="lname" value="<?php echo htmlentities($last); ?>" readonly />
        </tr>
        <tr>
          <td>パスワード</td>
          <td width="400"><?php print htmlspecialchars($password, ENT_COMPAT, 'utf-8'); ?></td>
          <input type="hidden" name="password" id="password" value="<?php echo htmlentities($password); ?>" readonly />
        </tr>
        <tr>
          <td>性別</td>
          <td width="400"><?php print htmlspecialchars($gender, ENT_COMPAT, 'utf-8'); ?></td>
          <input type="hidden" id="gender" name="gender" value="<?php echo htmlentities($gender); ?>" readonly />
        </tr>
        <tr>
          <td>メールを受け取る</td>
          <td><p><?php echo ($receiveEmails) ? "yes" : "no"; ?></p></td>
          <input type="hidden" id="receiveemails" name="receiveemails" value="<?php echo ($receiveEmails) ?>" readonly />
        </tr>
        <tr>
          <td>ファイル名</td>
          <td width="400"><?php print htmlspecialchars($fileName, ENT_COMPAT, 'utf-8'); ?></td>
          <input type="hidden" id="fileName" name="fileName" value="<?php echo htmlentities($fileName); ?>" readonly />
        </tr>
      </table>
      <p>この内容で宜しいですか？
      <input type="submit" name="submit" class="button" value="はい" /> 
    </form>

</body>
</html>