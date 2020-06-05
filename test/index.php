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
    $townDoubleZipCode;
    $townMultiAddress;
    $townAttachDistrict;
    $zipCodeMultiTown;
    $updateCheck;
    $updateReason;

    // define variables and initialize with empty values
    $publicGroupCodeErr = $zipCodeOldErr = $zipCodeErr = "";
    $prefectureKanaErr = $cityKanaErr = $townKanaErr = $prefectureErr = $cityErr = $townErr = "";
    $hasErrors = false;
    // console_log("POST is: " . print_r($_POST));
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        console_log("The request method was post");
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
        } else
        {
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
        } else
        {
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
        } else
        {
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
        } else
        {
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
        } else
        {
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
        } else
        {
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
        } else
        {
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
        } else
        {
            $town = $_POST["town"];
            $_SESSION["town"] = $_POST["town"];
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
        <label><?php echo $comment_table_fields[9] ?></label><br />
        <input type="radio" id="town_double_zip_code" name="town_double_zip_code" value="town_double_zip_code_match">
        <label for="town_double_zip_code">該当</label><br />
        <input type="radio" id="town_double_zip_code" name="town_double_zip_code" value="double_zip_code">
        <label for="town_double_zip_code">該当せず</label><br>
        <label></label><br />
        <input type="radio" id="town_multi_address" name="match" value="town_multi_address">
        <label for="town_multi_address">該当</label><br />
        <input type="radio" id="town_multi_address" name="town_multi_address" value="town_multi_address_nomatch">
        <label for="town_multi_address">該当せず</label><br>
        <label></label><br />
        <input type="radio" id="town_attach_district" name="match" value="town_attach_district">
        <label for="town_attach_district">該当</label><br />
        <input type="radio" id="town_multi_address" name="town_multi_address" value="town_multi_address">
        <label for="female">該当せず</label><br>
        <label></label><br />
        <input type="radio" id="zip_code_multi_town" name="match" value="zip_code_multi_town">
        <label for="zip_code_multi_town">該当</label><br />
        <input type="radio" id="zip_code_multi_town" name="zip_code_multi_town" value="zip_code_multi_town">
        <label for="female">該当せず</label><br>
        <label><?php echo $comment_table_fields[13] ?></label><br />
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">男</label><br />
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">女</label><br>
        <label><?php echo $comment_table_fields[14] ?></label><br />
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">男</label><br />
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">女</label><br>
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