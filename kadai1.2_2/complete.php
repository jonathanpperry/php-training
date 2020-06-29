<?php
  $first = $_GET['fname'];
  $last = $_GET['lname'];
  $gender = $_GET['gender'];
  if ($_GET['receiveemails'] == true) {
    $receiveEmails = "yes";
  } else {
    $receiveEmails = "no";
  }
  $password = $_GET['password'];
  $fileName = $_GET['fileName'];
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>Registration Complete</title>
  </head>
  <body>
    <h2>終了</h2>
    <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
          <td width="200">First Name</td>
          <td width="400"><?php print htmlentities($first); ?></td>
        </tr>
        <tr>
          <td>Last Name</td>
          <td width="400"><?php print htmlentities($last); ?></td>
        </tr>
        <tr>
          <td>Password</td>
          <td width="400"><?php print htmlentities($password); ?></td>
        </tr>
        <tr>
          <td>性別</td>
          <td width="400"><?php print htmlentities($gender); ?></td>
        </tr>
        <tr>
          <td>メールを受け取る</td>
          <td width="400"><?php print htmlentities($receiveEmails); ?></td>
        </tr>
        <tr>
          <td>ファイル名</td>
          <td width="400"><?php print htmlentities($fileName); ?></td>
        </tr>
      </table>

    <p>情報は登録されました。</p>
    <button onclick="window.location.href='index.php'">Back</button></br>
  </body>
</html>