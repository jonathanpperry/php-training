<!DOCTYPE html>
<html lang="ja">
<head>
<title>テストページ</title>
</head>
<body>
<h1>テストページ</h1>

<?php

  $table = '';
  foreach ($_SERVER as $key => $val) {
      $table .= '<tr>' . "\n";
      $table .= '<th>' . $key . '</th>' . "\n";
      $table .= '<td>' . $val . '</td>' . "\n";
      $table .= '</tr>' . "\n";
  }

  ?>
  <table style="width:100%">
  <?php
    echo $table;
  ?>
  </table>

</body>
</html>

<style>
table, th, td {
  border: 1px solid black;
}
</style>