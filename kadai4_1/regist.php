<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    // Start the session
    session_start();

    function clear_session_fields() {
      $_SESSION["public_group_code"] = null;
      $_SESSION["zip_code_old"] = null;
      $_SESSION["zip_code"] = null;
      $_SESSION["prefecture_kana"] = null;
      $_SESSION["city_kana"] = null;
      $_SESSION["town_kana"] = null;
      $_SESSION["prefecture"] = null;
      $_SESSION["city"] = null;
      $_SESSION["town"] = null;
      $_SESSION["town_double_zip_code"] = null;
      $_SESSION["town_multi_address"] = null;
      $_SESSION["town_attach_district"] = null;
      $_SESSION["zip_code_multi_town"] = null;
      $_SESSION["update_check"] = null;
      $_SESSION["update_reason"] = null;    
    }

    // Set the data from hidden POST in confirm.php
    $submission_data = array();
    array_push($submission_data, $_POST[$_SESSION["column_names"][0]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][1]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][2]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][3]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][4]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][5]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][6]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][7]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][8]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][9]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][10]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][11]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][12]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][13]]);
    array_push($submission_data, $_POST[$_SESSION["column_names"][14]]);

    // Check for the submission data to set blue success text
    if ($_SESSION["submitting"] == true) {
      $my_db = new MyDBControllerMySQL();
      // Connect again after insert if it occurred
      $my_db->connect();

      $table_name = "kadai_jonathan_ziplist";

      // Submit the data
      $data_inserted = $my_db->insert($table_name, $submission_data);
      if ($data_inserted == true) {
        $_SESSION["submit_success"] = true;
      } else {
        $_SESSION["submit_success"] = false;
      }
      $_SESSION["submission_data"] = null;
      $_SESSION["submitting"] = false;
      clear_session_fields();
      // Set submitted value to use in index page
      $_SESSION["submitted"] = true;
      // Set input bool to not display errors at first
      $_SESSION["input_hajimete"] = true;
      // Redirect to the list page
      header("Location: index.php");
      exit();
    }
?>