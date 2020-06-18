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

    // Close the db
    $my_db->close();

    // Tried using the implode function here but found a better way
    // foreach($download_data as $data_row) {
    //     $out .= implode(",", $data_row) . PHP_EOL;
    //     array_push($csv_array, $out);
    // }

    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');
    header('Cache-Control: max-age=0');

    $fp = fopen('php://output', 'w');

    foreach($download_data as $row) {
        fputcsv($fp, $row);
    }

    $result = fpassthru($fp);
    if (!$result) {
        $_SESSION["download_result"] = false;
    } else {
        $_SESSION["download_result"] = true;
    }

    // Close the file pointer
    fclose($fp);

    // Don't redirect back to the list page for some reason
?>
