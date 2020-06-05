<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    //declare arrays for saving properties
    $missing_errors = array();
    $format_errors = array();

    $my_db = new MyDBControllerMySQL();
    $my_db->connect();
    $comment_table_query = 
      "SHOW FULL COLUMNS FROM kadai_jonathan_ziplist";
    $comment_table_fields = $my_db->query($comment_table_query, "mysqli_fetch_array_with_argument", "Comment");

    // Close database connection
    $my_db->close();

    // Define variables for completed values
    $publicGroupCode;
    $zipCodeOld;
    $zipCode;
    $prefectureKana;
    $cityKana;
    $townKana;
    $prefecture;
    $city;
    $town;
    $townDoubleZipCode = 0;
    $townMultiAddress = 0;
    $townAttachDistrict = 0;
    $zipCodeMultiTown = 0;
    $updateCheck = 0;
    $updateReason = 0;

    // define variables and initialize with empty values
    $publicGroupCodeErr = $zipCodeOldErr = $zipCodeErr = "";
    $prefectureKanaErr = $cityKanaErr = $townKanaErr = $prefectureErr = $cityErr = $townErr = "";
    $hasErrors = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["public_group_code"])) {
            array_push($missing_errors, $comment_table_fields[0]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["public_group_code"])) {
            array_push($format_errors, $comment_table_fields[0]);
            $_SESSION["public_group_code"] = $_POST["public_group_code"];
            $hasErrors = true;
        } else {
            // Save the data in the session
            $publicGroupCode = $_POST["public_group_code"];
            $_SESSION["public_group_code"] = $publicGroupCode;
            console_log($publicGroupCode);
        }

        if (empty($_POST["zip_code_old"])) {
            array_push($missing_errors, $comment_table_fields[1]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["zip_code_old"])) {
            array_push($format_errors, $comment_table_fields[1]);
            $_SESSION["zip_code_old"] = $_POST["zip_code_old"];
            $hasErrors = true;
        } else {
            $zipCodeOld = $_POST["zip_code_old"];
            $_SESSION["zip_code_old"] = $zipCodeOld;
        }

        if (empty($_POST["zip_code"])) {
            array_push($missing_errors, $comment_table_fields[2]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["zip_code"])) {
            array_push($format_errors, $comment_table_fields[2]);
            $_SESSION["zip_code"] = $_POST["zip_code"];
            $hasErrors = true;
        } else {
            $zipCode = $_POST["zip_code"];
            $_SESSION["zip_code"] = $_POST["zip_code"];
        }

        // String inputs
        if (empty($_POST["prefecture_kana"])) {
            array_push($missing_errors, $comment_table_fields[3]);
            $hasErrors = true;
        } elseif (!is_string($_POST["prefecture_kana"])) {
            array_push($format_errors, $comment_table_fields[3]);
            $_SESSION["prefecture_kana"] = $_POST["prefecture_kana"];
            $hasErrors = true;
        } else {
            $prefectureKana = $_POST["prefecture_kana"];
            $_SESSION["prefecture_kana"] = $_POST["prefecture_kana"];
        }

        if (empty($_POST["city_kana"])) {
            array_push($missing_errors, $comment_table_fields[4]);
            $hasErrors = true;
        } elseif (!is_string($_POST["city_kana"])) {
            $_SESSION["city_kana"] = $_POST["city_kana"];
            array_push($format_errors, $comment_table_fields[4]);
            $hasErrors = true;
        } else {
            $cityKana = $_POST["city_kana"];
            $_SESSION["city_kana"] = $_POST["city_kana"];
        }

        if (empty($_POST["town_kana"])) {
            array_push($missing_errors, $comment_table_fields[5]);
            $hasErrors = true;
        } elseif (!is_string($_POST["town_kana"])) {
            $_SESSION["town_kana"] = $_POST["town_kana"];
            array_push($format_errors, $comment_table_fields[5]);
            $hasErrors = true;
        } else {
            $townKana = $_POST["town_kana"];
            $_SESSION["town_kana"] = $_POST["town_kana"];
        }
        if (empty($_POST["prefecture"])) {
            array_push($missing_errors, $comment_table_fields[6]);
            $hasErrors = true;
        } elseif (!is_string($_POST["prefecture"])) {
            $_SESSION["prefecture"] = $_POST["prefecture"];
            array_push($format_errors, $comment_table_fields[6]);
            $hasErrors = true;
        } else {
            $prefecture = $_POST["prefecture"];
            $_SESSION["prefecture"] = $_POST["prefecture"];
        }

        if (empty($_POST["city"])) {
            array_push($missing_errors, $comment_table_fields[7]);
            $hasErrors = true;
        } elseif (!is_string($_POST["city"])) {
            $_SESSION["city"] = $_POST["city"];
            array_push($format_errors, $comment_table_fields[7]);
            $hasErrors = true;
        } else {
            $city = $_POST["city"];
            $_SESSION["city"] = $_POST["city"];
        }

        if (empty($_POST["town"])) {
            array_push($missing_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } elseif (!is_string($_POST["town"])) {
            $_SESSION["town"] = $_POST["town"];
            array_push($format_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } else {
            $town = $_POST["town"];
            $_SESSION["town"] = $_POST["town"];
        }

        if (empty($_POST["town_double_zip_code"])) {
            array_push($missing_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["town_double_zip_code"])) {
            $_SESSION["town_double_zip_code"] = $_POST["town_double_zip_code"];
            array_push($format_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } else {
            $townDoubleZipCode = $_POST["town_double_zip_code"];
            $_SESSION["town_double_zip_code"] = $_POST["town_double_zip_code"];
        }

        if (empty($_POST["town_multi_address"])) {
            array_push($missing_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["town_multi_address"])) {
            $_SESSION["town_multi_address"] = $_POST["town_multi_address"];
            array_push($format_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } else {
            $townMultiAddress = $_POST["town_multi_address"];
            $_SESSION["town_multi_address"] = $_POST["town_multi_address"];
        }

        if (empty($_POST["town_attach_district"])) {
            array_push($missing_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["town_attach_district"])) {
            $_SESSION["town_attach_district"] = $_POST["town_attach_district"];
            array_push($format_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } else {
            $townAttachDistrict = $_POST["town_attach_district"];
            $_SESSION["town_attach_district"] = $_POST["town_attach_district"];
        }

        if (empty($_POST["zip_code_multi_town"])) {
            array_push($missing_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["zip_code_multi_town"])) {
            $_SESSION["zip_code_multi_town"] = $_POST["zip_code_multi_town"];
            array_push($format_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } else {
            $zipCodeMultiTown = $_POST["zip_code_multi_town"];
            $_SESSION["zip_code_multi_town"] = $_POST["zip_code_multi_town"];
        }

        if (empty($_POST["update_check"])) {
            array_push($missing_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["update_check"])) {
            $_SESSION["update_check"] = $_POST["update_check"];
            array_push($format_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } else {
            $updateCheck = $_POST["update_check"];
            $_SESSION["update_check"] = $_POST["update_check"];
        }

        if (empty($_POST["update_reason"])) {
            array_push($missing_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } elseif (!is_numeric($_POST["update_reason"])) {
            $_SESSION["update_reason"] = $_POST["update_reason"];
            array_push($format_errors, $comment_table_fields[8]);
            $hasErrors = true;
        } else {
            $updateReason = $_POST["update_reason"];
            $_SESSION["update_reason"] = $_POST["update_reason"];
        }

        // For now just log a message for errors
        if ($hasErrors) {
            console_log("There are errors!");
        } else {
            // Direct user to confirm page
            header("Location: confirm.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
  </head>
  <body>
    <h2>課題4_1へようこそ</h2>
    <!-- Loop through and display errors at the top -->
    <?php
    // Format
    if (sizeof($format_errors != 0)) {
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
    if (sizeof($missing_errors != 0)) {
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
    <form action="index.php" method="POST">
        <?php echo $comment_table_fields[0] ?>(数字): <input name="public_group_code" id="public_group_code" value=<?php print htmlspecialchars($_SESSION["public_group_code"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[1] ?>(数字): <input name="zip_code_old" id="zip_code_old" value=<?php print htmlspecialchars($_SESSION["zip_code_old"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[2] ?>(数字): <input name="zip_code" id="zip_code" value=<?php print htmlspecialchars($_SESSION["zip_code"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <!-- Text inputs -->
        <?php echo $comment_table_fields[3] ?>: <input name="prefecture_kana" id="prefecture_kana" value=<?php print htmlspecialchars($_SESSION["prefecture_kana"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[4] ?>: <input name="city_kana" id="city_kana" value=<?php print htmlspecialchars($_SESSION["city_kana"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[5] ?>: <input name="town_kana" id="town_kana" value=<?php print htmlspecialchars($_SESSION["town_kana"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[6] ?>: <input name="prefecture" id="prefecture" value=<?php print htmlspecialchars($_SESSION["prefecture"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[7] ?>: <input name="city" id="city" value=<?php print htmlspecialchars($_SESSION["city"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[8] ?>: <input name="town" id="town" value=<?php print htmlspecialchars($_SESSION["town"], ENT_COMPAT, 'utf-8'); ?>>
        <br />
        <?php echo $comment_table_fields[9] ?><select name="town_double_zip_code" id="town_double_zip_code" size="1">
            <option value="1">該当</option>
            <option value="0">該当せず</option>
        </select><br />
        <?php echo $comment_table_fields[10] ?><select name="town_multi_address" id="town_multi_address" size="1">
            <option value="1">該当</option>
            <option value="0">該当せず</option>
        </select><br />
        <?php echo $comment_table_fields[11] ?><select name="town_attach_district" id="town_attach_district" size="1">
            <option value="1">該当</option>
            <option value="0">該当せず</option>
        </select><br />
            <?php echo $comment_table_fields[12] ?><select name="zip_code_multi_town" id="zip_code_multi_town" size="1">
            <option value="1">該当</option>
            <option value="0">該当せず</option>
        </select><br />
        <?php echo $comment_table_fields[13] ?><select name="update_check" id="update_check" size="1">
            <option value="0">変更なし</option>    
            <option value="1">変更あり</option>
            <option value="2">廃止(廃止データのみ使用)</option>
        </select><br />
        <?php echo $comment_table_fields[14] ?><select name="update_reason" id="update_reason" size="1">
            <option value="0">変更なし</option>
            <option value="1">市政・区政・町政・分区・政令指定都市施行</option>
            <option value="2">住居表示の実施</option>
            <option value="3">区画整理</option>
            <option value="4">郵便区調整等</option>
            <option value="5">訂正</option>
            <option value="6">廃止(廃止データのみ使用)</option>
        </select><br />
        <!-- Reset and Submit Buttons -->
        <input type="reset" name="reset">
        <input type="submit" name="submit">
    </form>
  </body>
</html>

<style>
    .error {
        color: red;
    }
</style>