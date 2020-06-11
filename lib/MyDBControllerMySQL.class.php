<?php
class MyDBControllerMySQL
{
    //------------
    // 属性
    //------------
    var $db;      // DB接続オブジェクト
    var $error;   // エラーメッセージ(あると親切)

    var $db_host        = 'localhost';
    var $db_user        = 'root';
    var $db_pass        = 'M1ghty_cr@ft';
    var $db_database    = 'mc_kadai'; 
    var $db_port        = '3306';
    var $charset        = 'utf8mb4';
    var $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    function console_log( $data ) {
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    public $column_names = array();

    //------------
    // 操作
    //------------
    // コンストラクタ(DB接続)
        function __construct() {
        array_push($this->column_names, "public_group_code");
        array_push($this->column_names, "zip_code_old");
        array_push($this->column_names, "zip_code");
        array_push($this->column_names, "prefecture_kana");
        array_push($this->column_names, "city_kana");
        array_push($this->column_names, "town_kana");
        array_push($this->column_names, "prefecture");
        array_push($this->column_names, "city");
        array_push($this->column_names, "town");
        array_push($this->column_names, "town_double_zip_code");
        array_push($this->column_names, "town_multi_address");
        array_push($this->column_names, "town_attach_district");
        array_push($this->column_names, "zip_code_multi_town");
        array_push($this->column_names, "update_check");
        array_push($this->column_names, "update_reason");
    }

    // デストラクタ(DB切断)
    function __destruct() {
      $this->console_log("Destroying " . __CLASS__ . "\n");
    }

    // 接続
    function connect() {
        $this->db = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_database, $this->db_port);
        if (!$this->db) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        
        $successString = "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
        $successString .= "Host information: " . mysqli_get_host_info($this->db) . PHP_EOL;
        
        // Log the success string

        // Set UTF-8
        mysqli_set_charset($this->db, "utf8");
    }

    // 切断
    function close() {
      // Close the DB connection
      mysqli_close($this->db);
    }

    // SQL実行
    function query($queryString, $fieldName) {
        $return_array = array();

        // Create a prepared statement
        $stmt = mysqli_stmt_init($this->db);
        // Prepare the prepared statement
        if (!mysqli_stmt_prepare($stmt, $queryString)) {
            echo "SQL statement failed";
        } else {
            // Run parameters inside database
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
                if ($fieldName) {
                    array_push($return_array, $row[$fieldName]);
                } else {
                    array_push($return_array, $row);
                }
            }
        }
        return $return_array;
    }

    function insert($tableName, $insertData) : bool {
        $publicGroupCode = mysqli_real_escape_string($this->db, $insertData[0]);
        $zipCodeOld = mysqli_real_escape_string($this->db, $insertData[1]);
        $zipCode = mysqli_real_escape_string($this->db, $insertData[2]);
        $prefectureKana = mysqli_real_escape_string($this->db, $insertData[3]);
        $cityKana = mysqli_real_escape_string($this->db, $insertData[4]);
        $townKana = mysqli_real_escape_string($this->db, $insertData[5]);
        $prefecture = mysqli_real_escape_string($this->db, $insertData[6]);
        $city = mysqli_real_escape_string($this->db, $insertData[7]);
        $town = mysqli_real_escape_string($this->db, $insertData[8]);
        $townDoubleZipCode = mysqli_real_escape_string($this->db, $insertData[9]);
        $townMultiAddress = mysqli_real_escape_string($this->db, $insertData[10]);
        $townAttachDistrict = mysqli_real_escape_string($this->db, $insertData[11]);
        $zipCodeMultiTown = mysqli_real_escape_string($this->db, $insertData[12]);
        $updateCheck = mysqli_real_escape_string($this->db, $insertData[13]);
        $updateReason = mysqli_real_escape_string($this->db, $insertData[14]);

        $sql = "INSERT INTO " . $tableName . "(`{$this->column_names[0]}`, `{$this->column_names[1]}`,`{$this->column_names[2]}`,`{$this->column_names[3]}`,`{$this->column_names[4]}`,
            `{$this->column_names[5]}`,`{$this->column_names[6]}`,`{$this->column_names[7]}`,`{$this->column_names[8]}`,`{$this->column_names[9]}`,
            `{$this->column_names[10]}`,`{$this->column_names[11]}`,`{$this->column_names[12]}`,`{$this->column_names[13]}`,`{$this->column_names[14]}`)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

        // Create a prepared statement
        $stmt = mysqli_stmt_init($this->db);
        // Prepare the prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL error";
            return false;
        } else {
            mysqli_stmt_bind_param($stmt, "iiissssssiiiiii", $publicGroupCode, $zipCodeOld, $zipCode,
                $prefectureKana, $cityKana, $townKana, $prefecture, $city, $town, $townDoubleZipCode,
                $townMultiAddress, $townAttachDistrict, $zipCodeMultiTown, $updateCheck, $updateReason
            );
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    function select($queryString, $category, $search) : array {
        $searchString = mysqli_real_escape_string($this->db, $search);
        $searchString = "%" . $searchString . "%";
        $return_array = array();
        $sql = $queryString .
            " WHERE `{$this->column_names[$category]}` LIKE ?";
        // Create a prepared statement
        $stmt = mysqli_stmt_init($this->db);
        // Prepare the prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $searchString);
            // Run parameters inside database
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
                array_push($return_array, $row);
            }
        }
        return $return_array;
    }

    function selectByZip($publicGroupCode, $zipCodeOld, $zipCode) {
        // $return_data = array();
        // $sql = "SELECT * from "
        // // Create a prepared statement
        // $stmt = mysqli_stmt_init($this->db);
        // // Prepare the prepared statement
        // if (!mysqli_stmt_prepare($stmt, $sql)) {
        //     echo "SQL statement failed";
        // } else {
        //     mysqli_stmt_bind_param($stmt, "s", $searchString);
        //     // Run parameters inside database
        //     mysqli_stmt_execute($stmt);
        //     $result = mysqli_stmt_get_result($stmt);
        //     while($row = mysqli_fetch_assoc($result)) {
        //         array_push($return_array, $row);
        //     }
        // }
        // return $return_array;

    }
}
?>