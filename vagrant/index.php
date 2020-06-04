<?php
    header("Access-Control-Allow-Origin: *");
    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>1.2_1課題ページ</title>
</head>
<body>
    <h1>1.2_1課題ページ</h1>
    <table border="1">
    <?php
    if (isset($_GET['uuid'])) {
        echo $_GET['uuid'];
    } else {
        echo 'ないよ';
    }
    ?>
    </table>
</body>
</html>