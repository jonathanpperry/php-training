<?php
require_once '../lib/MyDBControllerMySQL.class.php';

// Start the session
session_start();
$my_db = new MyDBControllerMySQL();
$my_db->connect();

$table_name = "kadai_jonathan_ziplist";

$insert_item_array = array();
$num_cols = 15;

if (isset($_POST["upload"])) {
    if ($_FILES['file']['name']) {
        $filename = explode(".", $_FILES['file']['name']);
        if ($filename[1] == 'csv') {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            while ($data = fgetcsv($handle)) {
                // $my_db->console_log("I'm looping!");
                for ($x = 0; $x < $num_cols; $x++) {
                    $insert_item = mysqli_real_escape_string($my_db->db, $data[$x]);
                    array_push($insert_item_array, $insert_item);
                }
                $my_db->console_log($insert_item_array);
                $my_db->console_log("something");
            }
        }
    }
}

$my_db->close();

// header("Location: index.php");
// exit();