<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    $my_db = new MyDBControllerMySQL();

    $delete_data = array();
    $two_dim_array = array();
    if (isset($_POST["checkboxval"]))
    {
        foreach($_POST["checkboxval"] as $val)
        {
            $my_db->console_log($val);
            array_push($delete_data, $val);
            $postal_data_array = explode("/", $val);
            array_push($two_dim_array, $postal_data_array);
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>テストページ</title>
        <style>
            .blue-success-text {
                color: blue;
            }
            .red-error-text {
                color:red;
            }
        </style>
    </head>
    <body>
        <button onclick="history.back();">Back</button></br>

        <h3>次のものを削除しています</h3>
            <form method="POST" action="delete_regist.php">
                <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>
                        全国地方公共団体コード
                    </th>
                    <th>
                        旧郵便番号
                    </th>
                    <th>
                        郵便番号
                    </th>
                </tr>
                <?php
                    for ($x = 0; $x < count($delete_data); $x++)
                    {
                ?>
                    <tr>
                        <input type="hidden" name="<?php echo "delete_data_{$x}" ?>" value="<?php echo htmlspecialchars($delete_data[$x]); ?>" readonly />
                        <?php
                            print "<td width='200'>" . htmlspecialchars($two_dim_array[$x][0], ENT_COMPAT, 'utf-8') . "</td>";
                            print "<td width='200'>" . htmlspecialchars($two_dim_array[$x][1], ENT_COMPAT, 'utf-8') . "</td>";
                            print "<td width='200'>" . htmlspecialchars($two_dim_array[$x][2], ENT_COMPAT, 'utf-8') . "</td>";
                        ?>
                    </tr>
                <?php
                }
                ?>
                </table>
                <p>この内容で宜しいですか？
                <input type="submit" name="submit" class="button" value="はい" /> 
            </form>
    </body>
</html>
