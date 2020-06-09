<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    // Start the session
    session_start();

    // Array for data to loop through
    $submission_data = array();

    $my_db = new MyDBControllerMySQL();

    // Set value for input first time
    $_SESSION["input_hajimete"] = false;

    // Define variables for completed values
    array_push($submission_data, $_POST['public_group_code']);
    array_push($submission_data, $_POST['zip_code_old']);
    array_push($submission_data, $_POST['zip_code']);
    array_push($submission_data, $_POST['prefecture_kana']);
    array_push($submission_data, $_POST['city_kana']);
    array_push($submission_data, $_POST['town_kana']);
    array_push($submission_data, $_POST['prefecture']);
    array_push($submission_data, $_POST['city']);
    array_push($submission_data, $_POST['town']);
    array_push($submission_data, $_POST['town_double_zip_code']);
    array_push($submission_data, $_POST['town_multi_address']);
    array_push($submission_data, $_POST['town_attach_district']);
    array_push($submission_data, $_POST['zip_code_multi_town']);
    array_push($submission_data, $_POST['update_check']);
    array_push($submission_data, $_POST['update_reason']);
    $_SESSION["submission_data"] = $submission_data;
    // $my_db->console_log(("Submission data: " . print_r($_SESSION["submission_data"])));
    $comment_table_fields = $_SESSION["comment_table_fields"];
    $_SESSION["submitting"] = true;

    $hasErrors = false;
        if (empty($_POST["public_group_code"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["public_group_code"])) {
            $_SESSION["public_group_code"] = $_POST["public_group_code"];
            $hasErrors = true;
        } else {
            // Save the data in the session
            $_SESSION["public_group_code"] = $publicGroupCode;
        }

        if (empty($_POST["zip_code_old"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["zip_code_old"])) {
            $_SESSION["zip_code_old"] = $_POST["zip_code_old"];
            $hasErrors = true;
        } else {
            $_SESSION["zip_code_old"] = $zipCodeOld;
        }

        if (empty($_POST["zip_code"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["zip_code"])) {
            $_SESSION["zip_code"] = $_POST["zip_code"];
            $hasErrors = true;
        } else {
            $_SESSION["zip_code"] = $_POST["zip_code"];
        }

        // String inputs
        if (empty($_POST["prefecture_kana"])) {
            $hasErrors = true;
        } elseif (!is_string($_POST["prefecture_kana"])) {
            $_SESSION["prefecture_kana"] = $_POST["prefecture_kana"];
            $hasErrors = true;
        } else {
            $_SESSION["prefecture_kana"] = $_POST["prefecture_kana"];
        }

        if (empty($_POST["city_kana"])) {
            $hasErrors = true;
        } elseif (!is_string($_POST["city_kana"])) {
            $_SESSION["city_kana"] = $_POST["city_kana"];
            $hasErrors = true;
        } else {
            $_SESSION["city_kana"] = $_POST["city_kana"];
        }

        if (empty($_POST["town_kana"])) {
            $hasErrors = true;
        } elseif (!is_string($_POST["town_kana"])) {
            $_SESSION["town_kana"] = $_POST["town_kana"];
            $hasErrors = true;
        } else {
            $_SESSION["town_kana"] = $_POST["town_kana"];
        }
        if (empty($_POST["prefecture"])) {
            $hasErrors = true;
        } elseif (!is_string($_POST["prefecture"])) {
            $_SESSION["prefecture"] = $_POST["prefecture"];
            $hasErrors = true;
        } else {
            $_SESSION["prefecture"] = $_POST["prefecture"];
        }

        if (empty($_POST["city"])) {
            $hasErrors = true;
        } elseif (!is_string($_POST["city"])) {
            $_SESSION["city"] = $_POST["city"];
            $hasErrors = true;
        } else {
            $_SESSION["city"] = $_POST["city"];
        }

        if (empty($_POST["town"])) {
            $hasErrors = true;
        } elseif (!is_string($_POST["town"])) {
            $_SESSION["town"] = $_POST["town"];
            $hasErrors = true;
        } else {
            $_SESSION["town"] = $_POST["town"];
        }

        if (is_null($_POST["town_double_zip_code"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["town_double_zip_code"])) {
            $_SESSION["town_double_zip_code"] = $_POST["town_double_zip_code"];
            $hasErrors = true;
        } else {
            $_SESSION["town_double_zip_code"] = $_POST["town_double_zip_code"];
        }

        if (is_null($_POST["town_multi_address"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["town_multi_address"])) {
            $_SESSION["town_multi_address"] = $_POST["town_multi_address"];
            $hasErrors = true;
        } else {
            $_SESSION["town_multi_address"] = $_POST["town_multi_address"];
        }

        if (is_null($_POST["town_attach_district"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["town_attach_district"])) {
            $_SESSION["town_attach_district"] = $_POST["town_attach_district"];
            $hasErrors = true;
        } else {
            $_SESSION["town_attach_district"] = $_POST["town_attach_district"];
        }

        if (is_null($_POST["zip_code_multi_town"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["zip_code_multi_town"])) {
            $_SESSION["zip_code_multi_town"] = $_POST["zip_code_multi_town"];
            $hasErrors = true;
        } else {
            $_SESSION["zip_code_multi_town"] = $_POST["zip_code_multi_town"];
        }
        $my_db->console_log("Update check value is: " . $_POST["update_check"]);
        if (is_null($_POST["update_check"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["update_check"])) {
            $_SESSION["update_check"] = $_POST["update_check"];
            $hasErrors = true;
        } else {
            $_SESSION["update_check"] = $_POST["update_check"];
        }

        if (is_null($_POST["update_reason"])) {
            $hasErrors = true;
        } elseif (!is_numeric($_POST["update_reason"])) {
            $_SESSION["update_reason"] = $_POST["update_reason"];
            $hasErrors = true;
        } else {
            $_SESSION["update_reason"] = $_POST["update_reason"];
        }
        $my_db->console_log("Has errors: " . $hasErrors);
        // For now just log a message for errors
        if ($hasErrors) {
            // Direct user to confirm page
            header("Location: input.php");
            exit();
        }

    ?>

    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <title>テストページ</title>
    </head>
        <body>
            <h3>情報確認</h3>
            <button onclick="history.back();">Back</button></br>
            <form action="regist.php" method="POST">
                <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
                <?php
                    for($x = 0; $x < sizeof($comment_table_fields); $x++) {
                ?>
                <tr>
                    <?php
                    print "<td width='200'>" . htmlspecialchars($comment_table_fields[$x], ENT_COMPAT, 'utf-8') . "</td>";
                    if ($x < 9) {
                        print "<td width='400'>" . htmlspecialchars($submission_data[$x], ENT_COMPAT, 'utf-8') . "</td>";
                    } elseif ($x >= 9 && $x <= 12) {
                        print "<td width='400'>" . ($submission_data[$x] == 0 ? '該当' : '該当せず') . "</td>";
                    } elseif ($x == 13) {
                        if ($submission_data[$x] == 0) {
                            print "<td width='400'>変更なし</td>";
                        } elseif ($submission_data[$x] == 1) {
                            print "<td width='400'>変更あり</td>";
                        } elseif ($submission_data[$x] == 2) {
                            print "<td width='400'>廃止(廃止データのみ使用)</td>";
                        }
                    } elseif ($x == 14) {
                        if ($submission_data[$x] == 0) {
                            print "<td width='400'>変更なし</td>";
                        } elseif ($submission_data[$x] == 1) {
                            print "<td width='400'>市政・区政・町政・分区・政令指定都市施行</td>";
                        } elseif ($submission_data[$x] == 2) {
                            print "<td width='400'>住居表示の実施</td>";
                        } elseif ($submission_data[$x] == 3) {
                            print "<td width='400'>区画整理</td>";
                        } elseif ($submission_data[$x] == 4) {
                            print "<td width='400'>郵便区調整等</td>";
                        } elseif ($submission_data[$x] == 5) {
                            print "<td width='400'>訂正</td>";
                        } elseif ($submission_data[$x] == 6) {
                            print "<td width='400'>廃止(廃止データのみ使用)</td>";
                        }
                    }
                    ?>
                </tr>
                    <?php } ?>
                </table>
                <p>この内容で宜しいですか？
                <input type="submit" name="submit" class="button" value="はい" /> 
            </form>
        </body>
    </html>