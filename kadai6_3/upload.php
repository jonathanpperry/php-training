<?php
require_once '../lib/MyDBControllerMySQL.class.php';

// Start the session
session_start();
// Set output buffer
ob_start();

$my_db = new MyDBControllerMySQL();
$my_db->connect();

$table_name = "kadai_jonathan_ziplist";

$insert_item_array = array();
$num_cols = 15;

$duplicate_entries = 0;

// Set UTF-8
mysqli_set_charset($my_db->db, "utf8");

if (isset($_POST["upload"])) {
    if ($_FILES['file']['name']) {
        $filename = explode(".", $_FILES['file']['name']);
        if ($filename[1] == 'csv') {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            if ($handle !== false) {
                while ($data = fgetcsv($handle, 1000)) {
                    // If there is a row that has the wrong # of entries, interrupt upload
                    if (count($data) !== $num_cols) {
                        $_SESSION["upload_success"] = false;
                        $_SESSION["upload_error"] = "アップロードが中断されました。 データに1つ以上の不正な行があります。";
                        header("Location: index.php");
                        exit();
                    }
                    for ($x = 0; $x < $num_cols; $x++) {
                        $insert_item = mysqli_real_escape_string($my_db->db, mb_convert_encoding($data[$x], "utf-8", "SJIS"));
                        array_push($insert_item_array, $insert_item);
                    }
                    $insert_value = $my_db->insert($table_name, $insert_item_array);
                    if ($insert_value == false) {
                        // Must be a duplicate
                        $_SESSION["upload_success"] = false;
                        $_SESSION["upload_error"] = "1つ以上の行を挿入できませんでした。";
                        ++$duplicate_entries;
                    }
                    $insert_item_array = array();
                }
            } else {
                $_SESSION["upload_success"] = false;
                $_SESSION["upload_error"] = "File could not be opened.";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION["upload_success"] = false;
            $_SESSION["upload_error"] = "CSVファイル形式をアップロードしてください。";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION["upload_success"] = false;
        $_SESSION["upload_error"] = "アップロードエラーが発生しました。";
        header("Location: index.php");
        exit();
    }
}

if (count($duplicate_entries) > 0) {
    $_SESSION["upload_success"] = false;
    $_SESSION["duplicate_entries"] = $duplicate_entries;
} else {
    $_SESSION["upload_success"] = true;
}


$my_db->close();

header("Location: index.php");
exit();
