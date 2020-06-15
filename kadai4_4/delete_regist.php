<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    // Array of data to delete
    $delete_data_array = array();
    $my_db = new MyDBControllerMySQL();
    print_r(($_POST));

    $data_count = count($_POST)-1;
    $my_db->console_log(count($data_count));
    for ($x = 0; $x < $data_count; $x++) {
        $data = $_POST["delete_data_" . $x];
        array_push($delete_data_array, $data);
    }

    $my_db->connect();
    $table_name = "kadai_jonathan_ziplist";
    $complete_success = true;

    foreach ($delete_data_array as $data) {
        $exploded = explode("/", $data);
        if ($my_db->delete($exploded[0], $exploded[1], $exploded[2], $table_name) == false) {
            $complete_success = false;
        }
    }

    header("Location: index.php");
    exit();

?>