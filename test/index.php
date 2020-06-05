<?php
    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

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
            $publicGroupCodeErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_numeric($_POST["public_group_code"])) {
            $publicGroupCodeErr = "* Not numeric";
            $hasErrors = true;
        } else {
            // Save the data in the session
            $publicGroupCode = $_POST["public_group_code"];
            $_SESSION["public_group_code"] = $publicGroupCode;
            console_log($publicGroupCode);
        }

        if (empty($_POST["zip_code_old"])) {
            $zipCodeOldErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_numeric($_POST["zip_code_old"])) {
            $zipCodeOldErr = "* Not numeric";
            $hasErrors = true;
        } else
        {
            $zipCodeOld = $_POST["zip_code_old"];
            $_SESSION["zip_code_old"] = $zipCodeOld;
        }

        if (empty($_POST["zip_code"])) {
            $zipCodeErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_numeric($_POST["zip_code"])) {
            $zipCodeErr = "* Not numeric";
            $hasErrors = true;
        } else
        {
            $zipCode = $_POST["zip_code"];
        }
        // String inputs
        if (empty($_POST["prefecture_kana"])) {
            $prefectureKanaErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_string($_POST["prefecture_kana"])) {
            $prefectureKanaErr = "* Not numeric";
            $hasErrors = true;
        } else
        {
            $prefectureKana = $_POST["prefecture_kana"];
        }

        if (empty($_POST["city_kana"])) {
            $cityKanaErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_string($_POST["city_kana"])) {
            $cityKanaErr = "* Not numeric";
            $hasErrors = true;
        } else
        {
            $cityKana = $_POST["city_kana"];

        }

        if (empty($_POST["town_kana"])) {
            $townKanaErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_string($_POST["town_kana"])) {
            $townKanaErr = "* Not numeric";
            $hasErrors = true;
        } else
        {
            $townKana = $_POST["town_kana"];
        }
        if (empty($_POST["prefecture"])) {
            $prefectureErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_string($_POST["prefecture"])) {
            $prefectureErr = "* Not numeric";
            $hasErrors = true;
        } else
        {
            $prefecture = $_POST["prefecture"];
        }
        if (empty($_POST["city"])) {
            $cityErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_string($_POST["city"])) {
            $cityErr = "* Not numeric";
            $hasErrors = true;
        } else
        {
            $city = $_POST["city"];
        }
        if (empty($_POST["town"])) {
            $townErr = "* Missing";
            $hasErrors = true;
        } elseif (!is_string($_POST["town"])) {
            $townErr = "* Not numeric";
            $hasErrors = true;
        } else
        {
            $town = $_POST["town"];
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
    <form action="index.php" method="POST">
        全国地方公共団体コード(数字): <input name="public_group_code" id="public_group_code" value=<?php print htmlspecialchars($_SESSION["public_group_code"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $publicGroupCodeErr;?></span>
        <br><br>

        旧郵便番号(数字): <input name="zip_code_old" id="zip_code_old" value=<?php print htmlspecialchars($_SESSION["zip_code_old"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $zipCodeOldErr;?></span>
        <br><br>

        郵便番号(数字): <input name="zip_code" id="zip_code" value=<?php print htmlspecialchars($_SESSION["zip_code"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $zipCodeErr;?></span>
        <br><br>

        <!-- Text inputs -->
        都道府県名(半角カタカナ): <input name="prefecture_kana" id="prefecture_kana" value=<?php print htmlspecialchars($_SESSION["prefecture_kana"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $prefectureKanaErr;?></span>
        <br><br>

        市区町村名(半角カタカナ): <input name="city_kana" id="city_kana" value=<?php print htmlspecialchars($_SESSION["city_kana"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $cityKanaErr;?></span>
        <br><br>

        町域名(半角カタカナ): <input name="town_kana" id="town_kana" value=<?php print htmlspecialchars($_SESSION["town_kana"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $townKanaErr;?></span>
        <br><br>

        都道府県名(漢字): <input name="prefecture" id="prefecture" value=<?php print htmlspecialchars($_SESSION["prefecture"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $prefectureErr;?></span>
        <br><br>

        市区町村名(漢字): <input name="city" id="city" value=<?php print htmlspecialchars($_SESSION["city"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $cityErr;?></span>
        <br><br>

        町域名(漢字): <input name="town" id="town" value=<?php print htmlspecialchars($_SESSION["town"], ENT_COMPAT, 'utf-8'); ?>>
        <span class="error"><?php echo $townErr;?></span>
        <br><br>

        <label>一町域で複数の郵便番号か</label><br />
        <input type="radio" id="town_double_zip_code" name="town_double_zip_code" value="town_double_zip_code_match">
        <label for="town_double_zip_code">該当</label><br />
        <input type="radio" id="town_double_zip_code" name="town_double_zip_code" value="double_zip_code">
        <label for="town_double_zip_code">該当せず</label><br>
        <label>小字毎に番地が起番されている町域か</label><br />
        <input type="radio" id="town_multi_address" name="match" value="town_multi_address">
        <label for="town_multi_address">該当</label><br />
        <input type="radio" id="town_multi_address" name="town_multi_address" value="town_multi_address_nomatch">
        <label for="town_multi_address">該当せず</label><br>
        <label>丁目を有する町域名か</label><br />
        <input type="radio" id="town_attach_district" name="match" value="town_attach_district">
        <label for="town_attach_district">該当</label><br />
        <input type="radio" id="town_multi_address" name="town_multi_address" value="town_multi_address">
        <label for="female">該当せず</label><br>
        <label>一郵便番号で複数の町域か</label><br />
        <input type="radio" id="zip_code_multi_town" name="match" value="zip_code_multi_town">
        <label for="zip_code_multi_town">該当</label><br />
        <input type="radio" id="zip_code_multi_town" name="zip_code_multi_town" value="zip_code_multi_town">
        <label for="female">該当せず</label><br>
        <label>更新確認</label><br />
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">男</label><br />
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">女</label><br>
        <label>更新理由</label><br />
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