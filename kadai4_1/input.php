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

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    if (!$_SESSION["in_progress"]) {
        $_SESSION["in_progress"] = true;
    }

    //declare arrays for saving properties
    $missing_errors = array();
    $format_errors = array();

    if ($_SESSION["input_hajimete"] == true) {
        clear_session_fields();
    }

    $my_db = new MyDBControllerMySQL();
    $my_db->connect();
    $comment_table_query = 
      "SHOW FULL COLUMNS FROM kadai_jonathan_ziplist";
    $comment_table_fields = $my_db->query($comment_table_query, "mysqli_fetch_array_with_argument", "Comment");

    $_SESSION["comment_table_fields"] = $comment_table_fields;

    // Close database connection
    $my_db->close();

    // Set data from session if it exists to display previous values
    $publicGroupCode = $_SESSION["submission_data"][0];
    $zipCodeOld = $_SESSION["submission_data"][1];
    $zipCode = $_SESSION["submission_data"][2];
    $prefectureKana = $_SESSION["submission_data"][3];
    $cityKana = $_SESSION["submission_data"][4];
    $townKana = $_SESSION["submission_data"][5];
    $prefecture = $_SESSION["submission_data"][6];
    $city = $_SESSION["submission_data"][7];
    $town = $_SESSION["submission_data"][8];
    $townDoubleZipCode = $_SESSION["submission_data"][9];
    $townMultiAddress = $_SESSION["submission_data"][10];
    $townAttachDistrict = $_SESSION["submission_data"][11];
    $zipCodeMultiTown = $_SESSION["submission_data"][12];
    $updateCheck = $_SESSION["submission_data"][13];
    $updateReason = $_SESSION["submission_data"][14];

    // define variables and initialize with empty values
    $publicGroupCodeErr = $zipCodeOldErr = $zipCodeErr = "";
    $prefectureKanaErr = $cityKanaErr = $townKanaErr = $prefectureErr = $cityErr = $townErr = "";
    $_SESSION["has_errors"] = false;
    if (empty($publicGroupCode)) {
        array_push($missing_errors, $comment_table_fields[0]);
        $hasErrors = true;
    } elseif (!is_numeric($publicGroupCode)) {
        array_push($format_errors, $comment_table_fields[0]);
        $_SESSION["public_group_code"] = $_SESSION["public_group_code"];
        $hasErrors = true;
    } else {
        // Save the data in the session
        $_SESSION["public_group_code"] = $publicGroupCode;
    }

    if (empty($zipCodeOld)) {
        array_push($missing_errors, $comment_table_fields[1]);
        $hasErrors = true;
    } elseif (!is_numeric($zipCodeOld)) {
        array_push($format_errors, $comment_table_fields[1]);
        $_SESSION["zip_code_old"] = $_SESSION["zip_code_old"];
        $hasErrors = true;
    } else {
        $_SESSION["zip_code_old"] = $zipCodeOld;
    }

    if (empty($zipCode)) {
        array_push($missing_errors, $comment_table_fields[2]);
        $hasErrors = true;
    } elseif (!is_numeric($zipCode)) {
        array_push($format_errors, $comment_table_fields[2]);
        $_SESSION["zip_code"] = $_SESSION["zip_code"];
        $hasErrors = true;
    } else {
        $_SESSION["zip_code"] = $_SESSION["zip_code"];
    }

    // String inputs
    if (empty($_SESSION["prefecture_kana"])) {
        array_push($missing_errors, $comment_table_fields[3]);
        $hasErrors = true;
    } elseif (!is_string($_SESSION["prefecture_kana"])) {
        array_push($format_errors, $comment_table_fields[3]);
        $_SESSION["prefecture_kana"] = $_SESSION["prefecture_kana"];
        $hasErrors = true;
    } else {
        $_SESSION["prefecture_kana"] = $_SESSION["prefecture_kana"];
    }

    if (empty($_SESSION["city_kana"])) {
        array_push($missing_errors, $comment_table_fields[4]);
        $hasErrors = true;
    } elseif (!is_string($_SESSION["city_kana"])) {
        $_SESSION["city_kana"] = $_SESSION["city_kana"];
        array_push($format_errors, $comment_table_fields[4]);
        $hasErrors = true;
    } else {
        $_SESSION["city_kana"] = $_SESSION["city_kana"];
    }

    if (empty($_SESSION["town_kana"])) {
        array_push($missing_errors, $comment_table_fields[5]);
        $hasErrors = true;
    } elseif (!is_string($_SESSION["town_kana"])) {
        $_SESSION["town_kana"] = $_SESSION["town_kana"];
        array_push($format_errors, $comment_table_fields[5]);
        $hasErrors = true;
    } else {
        $_SESSION["town_kana"] = $_SESSION["town_kana"];
    }
    if (empty($_SESSION["prefecture"])) {
        array_push($missing_errors, $comment_table_fields[6]);
        $hasErrors = true;
    } elseif (!is_string($_SESSION["prefecture"])) {
        $_SESSION["prefecture"] = $_SESSION["prefecture"];
        array_push($format_errors, $comment_table_fields[6]);
        $hasErrors = true;
    } else {
        $_SESSION["prefecture"] = $_SESSION["prefecture"];
    }

    if (empty($_SESSION["city"])) {
        array_push($missing_errors, $comment_table_fields[7]);
        $hasErrors = true;
    } elseif (!is_string($_SESSION["city"])) {
        $_SESSION["city"] = $_SESSION["city"];
        array_push($format_errors, $comment_table_fields[7]);
        $hasErrors = true;
    } else {
        $_SESSION["city"] = $_SESSION["city"];
    }

    if (empty($_SESSION["town"])) {
        array_push($missing_errors, $comment_table_fields[8]);
        $hasErrors = true;
    } elseif (!is_string($_SESSION["town"])) {
        $_SESSION["town"] = $_SESSION["town"];
        array_push($format_errors, $comment_table_fields[8]);
        $hasErrors = true;
    } else {
        $_SESSION["town"] = $_SESSION["town"];
    }

    if (is_null($_SESSION["town_double_zip_code"])) {
        array_push($missing_errors, $comment_table_fields[9]);
        $hasErrors = true;
    } elseif (!is_numeric($_SESSION["town_double_zip_code"])) {
        $_SESSION["town_double_zip_code"] = $_SESSION["town_double_zip_code"];
        array_push($format_errors, $comment_table_fields[9]);
        $hasErrors = true;
    } else {
        $_SESSION["town_double_zip_code"] = $_SESSION["town_double_zip_code"];
    }

    if (is_null($_SESSION["town_multi_address"])) {
        array_push($missing_errors, $comment_table_fields[10]);
        $hasErrors = true;
    } elseif (!is_numeric($_SESSION["town_multi_address"])) {
        $_SESSION["town_multi_address"] = $_SESSION["town_multi_address"];
        array_push($format_errors, $comment_table_fields[10]);
        $hasErrors = true;
    } else {
        $_SESSION["town_multi_address"] = $_SESSION["town_multi_address"];
    }

    if (is_null($_SESSION["town_attach_district"])) {
        array_push($missing_errors, $comment_table_fields[11]);
        $hasErrors = true;
    } elseif (!is_numeric($_SESSION["town_attach_district"])) {
        $_SESSION["town_attach_district"] = $_SESSION["town_attach_district"];
        array_push($format_errors, $comment_table_fields[11]);
        $hasErrors = true;
    } else {
        $_SESSION["town_attach_district"] = $_SESSION["town_attach_district"];
    }

    if (is_null($_SESSION["zip_code_multi_town"])) {
        array_push($missing_errors, $comment_table_fields[12]);
        $hasErrors = true;
    } elseif (!is_numeric($_SESSION["zip_code_multi_town"])) {
        $_SESSION["zip_code_multi_town"] = $_SESSION["zip_code_multi_town"];
        array_push($format_errors, $comment_table_fields[12]);
        $hasErrors = true;
    } else {
        $_SESSION["zip_code_multi_town"] = $_SESSION["zip_code_multi_town"];
    }
    $my_db->console_log("Update check value is: " . $_SESSION["update_check"]);
    if (is_null($_SESSION["update_check"])) {
        array_push($missing_errors, $comment_table_fields[13]);
        $hasErrors = true;
    } elseif (!is_numeric($_SESSION["update_check"])) {
        $_SESSION["update_check"] = $_SESSION["update_check"];
        array_push($format_errors, $comment_table_fields[13]);
        $hasErrors = true;
    } else {
        $_SESSION["update_check"] = $_SESSION["update_check"];
    }

    if (is_null($_SESSION["update_reason"])) {
        array_push($missing_errors, $comment_table_fields[14]);
        $hasErrors = true;
    } elseif (!is_numeric($_SESSION["update_reason"])) {
        $_SESSION["update_reason"] = $_SESSION["update_reason"];
        array_push($format_errors, $comment_table_fields[14]);
        $hasErrors = true;
    } else {
        $_SESSION["update_reason"] = $_SESSION["update_reason"];
    }

    // For now just log a message for errors
    if ($hasErrors) {
        console_log("There are errors!");
    }

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
    <style>
        .error {
            color: red;
        }
    </style>
  </head>
  <body>
    <h2>入力ページ</h2>
    <!-- Loop through and display errors at the top -->
    <?php
    // Format
    if (sizeof($format_errors != 0) && $_SESSION["input_hajimete"] == false) {
        print "<span class='error'>";
        for ($x=0; $x < sizeof($format_errors); $x++) {
            // If it's not the last iteration
            if ($x != sizeof($format_errors)-1) {
                echo $format_errors[$x] . ", ";
            } else {
                echo $format_errors[$x] . "の型が不正です。";
            }
        }
        print "</span><br />";
    }
    // Missing errors
    if (sizeof($missing_errors != 0) && $_SESSION["input_hajimete"] == false) {
        print "<span class='error'>";
        for ($x=0; $x < sizeof($missing_errors); $x++) {
            // If it's not the last iteration
            if ($x != sizeof($missing_errors)-1) {
                echo $missing_errors[$x] . ", ";
            } else {
                echo $missing_errors[$x] . "が未入力です。";
            }
        }
        print "</span><br />";
    }
    ?>
    <br />
    <form action="confirm.php" method="POST">
        <?php echo $comment_table_fields[0] ?>(数字): <input name="public_group_code" id="public_group_code" value=<?php print htmlspecialchars($publicGroupCode, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[1] ?>(数字): <input name="zip_code_old" id="zip_code_old" value=<?php print htmlspecialchars($zipCodeOld, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[2] ?>(数字): <input name="zip_code" id="zip_code" value=<?php print htmlspecialchars($zipCode, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <!-- Text inputs -->
        <?php echo $comment_table_fields[3] ?>: <input name="prefecture_kana" id="prefecture_kana" value=<?php print htmlspecialchars($prefectureKana, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[4] ?>: <input name="city_kana" id="city_kana" value=<?php print htmlspecialchars($cityKana, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[5] ?>: <input name="town_kana" id="town_kana" value=<?php print htmlspecialchars($townKana, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[6] ?>: <input name="prefecture" id="prefecture" value=<?php print htmlspecialchars($prefecture, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[7] ?>: <input name="city" id="city" value=<?php print htmlspecialchars($city, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[8] ?>: <input name="town" id="town" value=<?php print htmlspecialchars($town, ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[9] ?><select name="town_double_zip_code" id="town_double_zip_code" size="1">
            <option value="1" <?php if($townDoubleZipCode == 1) print 'selected' ?>> 該当</option>
            <option value="0" <?php if($townDoubleZipCode == 0) print 'selected' ?>> 該当せず</option>
        </select><br />
        <?php echo $comment_table_fields[10] ?><select name="town_multi_address" id="town_multi_address" size="1">
            <option value="1" <?php if($townMultiAddress == 1) print 'selected' ?>> 該当</option>
            <option value="0" <?php if($townMultiAddress == 0) print 'selected' ?>> 該当せず</option>
        </select><br />
        <?php echo $comment_table_fields[11] ?><select name="town_attach_district" id="town_attach_district" size="1">
            <option value="1" <?php if($townAttachDistrict == 1) print 'selected' ?>> 該当</option>
            <option value="0" <?php if($townAttachDistrict == 0) print 'selected' ?>> 該当せず</option>
        </select><br />
            <?php echo $comment_table_fields[12] ?><select name="zip_code_multi_town" id="zip_code_multi_town" size="1">
            <option value="1" <?php if($zipCodeMultiTown == 1) print 'selected' ?>> 該当</option>
            <option value="0" <?php if($zipCodeMultiTown == 0) print 'selected' ?>> 該当せず</option>
        </select><br />
        <?php echo $comment_table_fields[13] ?><select name="update_check" id="update_check" size="1">
            <option value="0" <?php if($updateCheck == 0) print 'selected' ?>> 変更なし</option>
            <option value="1" <?php if($updateCheck == 1) print 'selected' ?>> 変更あり</option>
            <option value="2" <?php if($updateCheck == 2) print 'selected' ?>> 廃止(廃止データのみ使用)</option>
        </select><br />
        <?php echo $comment_table_fields[14] ?>
        <select name="update_reason" id="update_reason" size="1">
            <option value="0" <?php if($updateReason == 0) print 'selected' ?>> 変更なし</option>
            <option value="1" <?php if($updateReason == 1) print 'selected' ?>> 市政・区政・町政・分区・政令指定都市施行</option>
            <option value="2" <?php if($updateReason == 2) print 'selected' ?>> 住居表示の実施</option>
            <option value="3" <?php if($updateReason == 3) print 'selected' ?>> 区画整理</option>
            <option value="4" <?php if($updateReason == 4) print 'selected' ?>> 郵便区調整等</option>
            <option value="5" <?php if($updateReason == 5) print 'selected' ?>> 訂正</option>
            <option value="6" <?php if($updateReason == 6) print 'selected' ?>> 廃止(廃止データのみ使用)</option>
        </select><br />
        <!-- Reset and Submit Buttons -->
        <input type="reset" name="reset">
        <input type="submit" name="submit">
    </form>
  </body>
</html>
