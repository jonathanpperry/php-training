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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        console_log("The request method was post");
        if (empty($_POST["public_group_code"])) {
            $publicGroupCodeErr = "Missing";
            $hasErrors = true;
        }
        elseif (!is_numeric($_POST["public_group_code"])) {
            $publicGroupCodeErr = "Not numeric";
            $hasErrors = true;
        }
        else
        {
            $publicGroupCode = $_POST["public_group_code"];
        }
        if (empty($_POST["zip_code_old"])) {
            $publicGroupCodeErr = "Missing";
            $hasErrors = true;
        }
        elseif (!is_numeric($_POST["zip_code_old"])) {
            $publicGroupCodeErr = "Not numeric";
            $hasErrors = true;
        }
        else
        {
            $publicGroupCode = $_POST["zip_code_old"];
        }
        if (empty($_POST["public_group_code"])) {
            $publicGroupCodeErr = "Missing";
            $hasErrors = true;
        }
        elseif (!is_numeric($_POST["public_group_code"])) {
            $publicGroupCodeErr = "Not numeric";
            $hasErrors = true;
        }
        else
        {
            $publicGroupCode = $_POST["public_group_code"];
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
      全国地方公共団体コード: <input name="public_group_code" id="public_group_code"><br />
      旧郵便番号: <input name="zip_code_old" id="zip_code_old"><br />
      郵便番号: <input name="zip_code" id="zip_code"><br />
      都道府県名(半角カタカナ): <input name="prefecture_kana" id="prefecture_kana"><br />
      市区町村名(半角カタカナ): <input name="city_kana" id="city_kana"><br />
      町域名(半角カタカナ): <input name="town_kana" id="town_kana"><br />
      都道府県名(漢字): <input name="prefecture" id="prefecture"><br />
      市区町村名(漢字)	: <input name="city" id="city"><br />
      町域名(漢字)	: <input name="town" id="town"><br />
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
      <input type="radio" id="female" name="gender" value="female">
      <label for="female">該当せず</label><br>
      <label>一郵便番号で複数の町域か</label><br />
      <input type="radio" id="zip_code_multi_town" name="match" value="zip_code_multi_town">
      <label for="zip_code_multi_town">該当</label><br />
      <input type="radio" id="female" name="match" value="female">
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