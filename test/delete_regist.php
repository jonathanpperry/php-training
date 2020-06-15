<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    $my_db = new MyDBControllerMySQL();

    $delete_data = array();
    $two_dim_array = array();

    if (isset($_POST["checkboxval"]))
    {
        foreach($_POST["checkboxval"] as $val)
        {
            array_push($delete_data, $val);
            $postal_data_array = explode("/", $val);
            array_push($two_dim_array, $postal_data_array);
        }
    }
    $my_db->console_log($delete_data);

    // // Array of data to delete
    // $delete_data_array = array();

    // $data_count = count($_POST)-1;
    // for ($x = 0; $x < $data_count; $x++) {
    //     $data = $_POST["delete_data_" . $x];
    //     array_push($delete_data_array, $data);
    // }

    $my_db->connect();
    $table_name = "kadai_jonathan_ziplist";
    $complete_success = true;

    foreach ($delete_data as $data) {
        $exploded = explode("/", $data);
        if ($my_db->delete($exploded[0], $exploded[1], $exploded[2], $table_name) == false) {
            $complete_success = false;
        }
    }

    header("Location: index.php");
    exit();

?>