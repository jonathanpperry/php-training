<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
  </head>
  <body>
    <h2>1日目,2日目へようこそ</h2>
    <form action="confirm.php" method="POST">
      名前: <input type="text" name="fname" id="fname"><br />
      名字: <input type="text" name="lname" id="lname"><br />
      パスワード: <input type="password" name="password" id="password"><br />
      <label>性別</label><br />
      <input type="radio" id="male" name="gender" value="male" checked>
      <label for="male">男</label><br />
      <input type="radio" id="female" name="gender" value="female">
      <label for="female">女</label><br>
      <input type="file" name="fileName" id="fileToUpload"><br />
      <input type="checkbox" id="receiveemails" name="receiveemails" value="yes" checked>
      <label for="receiveemails">メールを受信することに同意します</label><br />
      <!-- Reset and Submit Buttons -->
      <input type="reset" name="reset">
      <input type="submit" name="submit">
    </form>
  </body>
</html>