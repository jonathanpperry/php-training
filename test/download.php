<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    require_once '../lib/validation.class.php';
    // Start the session
    session_start();

    $my_db = new MyDBControllerMySQL();
    $my_db->connect();
    $table_name = "kadai_jonathan_ziplist";

    $download_data = array();
    $csv_array = array();

    foreach($_POST["downloadcheckboxval"] as $val) {
        $exploded = explode("/", $val);
        $dataRow = $my_db->selectByZip($exploded[0], $exploded[1], $exploded[2], $table_name)[0];
        array_push($download_data, $dataRow);
    }

    $my_db->console_log(count($download_data));
    if (count($download_data) == 0) {
        // Redirect user back to list page with error
        $_SESSION["no_files_selected_error"] = true;
        header("Location: index.php");
        exit();
    }

    // Close the db
    $my_db->close();

    $my_db->console_log("Made it here");
    foreach($download_data as $data_row) {
        $out .= implode(",", $data_row) . "\r\n";
        array_push($csv_array, $out);
    }

    $my_db->console_log($csv_array);

    $fp = fopen('php://output', 'w');
    ob_end_clean();

    foreach($csv_array as $row) {
        fputcsv($fp, $row);
    }

    //set headers to download file rather than display
    // header('Content-Type: text/csv; charset=utf-8');
    // header('Content-Disposition: attachment; filename="export.csv"');
    // header('Cache-Control: max-age=0');
    // exit();

    // Rewind the file pointer
    rewind($fp);
    // Close the file pointer
    fclose($fp);
    
?>
