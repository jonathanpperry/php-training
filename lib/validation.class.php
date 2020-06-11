<?php
class Validation
{
    //------------
    // 属性
    //------------
    var $db;      // DB接続オブジェクト

    // define variables and initialize with empty values
    var $publicGroupCodeErr;
    var $zipCodeOldErr;
    var $zipCodeErr;
    var $prefectureKanaErr;
    var $cityKanaErr;
    var $townKanaErr;
    var $prefectureErr;
    var $cityErr;
    var $townErr;

    // Arrays
    //declare arrays for saving properties
    var $missing_errors = array();
    var $format_errors = array();

    function console_log( $data ) {
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    function is_hankatakana($text)
    {
        if (mb_ereg("^[ｱ-ﾝﾞﾟｧ-ｫｬ-ｮｰ｡｢｣､]+$", $text)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //------------
    // 操作
    //------------
    // コンストラクタ(DB接続)
    function __construct() {
    }

    // デストラクタ(DB切断)
    function __destruct() {
        $this->console_log("Destroying " . __CLASS__ . "\n");
    }

    function clearErrors() {
        $this->publicGroupCodeErr = null;
        $this->zipCodeOldErr = null;
        $this->zipCodeErr = null;
        $this->prefectureKanaErr = null;
        $this->cityKanaErr = null;
        $this->townKanaErr = null;
        $this->prefectureErr = null;
        $this->cityErr = null;
        $this->townErr = null;
    }

    function checkForErrors($submissionData, $comment_table_fields) {
        // Set data from session if it exists to display previous values
        $publicGroupCode = $submissionData[0];
        $zipCodeOld = $submissionData[1];
        $zipCode = $submissionData[2];
        $prefectureKana = $submissionData[3];
        $cityKana = $submissionData[4];
        $townKana = $submissionData[5];
        $prefecture = $submissionData[6];
        $city = $submissionData[7];
        $town = $submissionData[8];
        $townDoubleZipCode = $submissionData[9];
        $townMultiAddress = $submissionData[10];
        $townAttachDistrict = $submissionData[11];
        $zipCodeMultiTown = $submissionData[12];
        $updateCheck = $submissionData[13];
        $updateReason = $submissionData[14];

        if (empty($publicGroupCode)) {
            array_push($this->missing_errors, $comment_table_fields[0]);
        } elseif (!is_numeric($publicGroupCode)) {
            array_push($this->format_errors, $comment_table_fields[0]);
        }

        if (empty($zipCodeOld)) {
            array_push($this->missing_errors, $comment_table_fields[1]);
        } elseif (!is_numeric($zipCodeOld)) {
            array_push($this->format_errors, $comment_table_fields[1]);
        }

        if (empty($zipCode)) {
            array_push($this->missing_errors, $comment_table_fields[2]);
        } elseif (!is_numeric($zipCode)) {
            array_push($this->format_errors, $comment_table_fields[2]);
        }

        // String inputs
        if (empty($prefectureKana)) {
            $this->console_log($comment_table_fields[3]);
            array_push($this->missing_errors, $comment_table_fields[3]);
        } elseif (!is_string($prefectureKana) || !$this->is_hankatakana($prefectureKana)) {
            array_push($this->format_errors, $comment_table_fields[3]);
        }

        if (empty($cityKana)) {
            array_push($this->missing_errors, $comment_table_fields[4]);
        } elseif (!is_string($cityKana) || !$this->is_hankatakana($cityKana)) {
            array_push($this->format_errors, $comment_table_fields[4]);
        }

        if (empty($townKana)) {
            array_push($this->missing_errors, $comment_table_fields[5]);
        } elseif (!is_string($townKana) || !$this->is_hankatakana($townKana)) {
            array_push($this->format_errors, $comment_table_fields[5]);
        }

        if (empty($prefecture)) {
            array_push($this->missing_errors, $comment_table_fields[6]);
        } elseif (!is_string($prefecture)) {
            array_push($this->format_errors, $comment_table_fields[6]);
        }

        if (empty($city)) {
            array_push($this->missing_errors, $comment_table_fields[7]);
        } elseif (!is_string($city)) {
            array_push($this->format_errors, $comment_table_fields[7]);
        }

        if (empty($town)) {
            array_push($this->missing_errors, $comment_table_fields[8]);
        } elseif (!is_string($town)) {
            array_push($this->format_errors, $comment_table_fields[8]);
        }

        if (is_null($townDoubleZipCode)) {
            array_push($this->missing_errors, $comment_table_fields[9]);
        } elseif (!is_numeric($townDoubleZipCode)) {
            array_push($this->format_errors, $comment_table_fields[9]);
        }

        if (is_null($townMultiAddress)) {
            array_push($this->missing_errors, $comment_table_fields[10]);
        } elseif (!is_numeric($townMultiAddress)) {
            array_push($this->format_errors, $comment_table_fields[10]);
        }

        if (is_null($townAttachDistrict)) {
            array_push($this->missing_errors, $comment_table_fields[11]);
        } elseif (!is_numeric($townAttachDistrict)) {
            array_push($this->format_errors, $comment_table_fields[11]);
        }

        if (is_null($zipCodeMultiTown)) {
            array_push($this->missing_errors, $comment_table_fields[12]);
        } elseif (!is_numeric($zipCodeMultiTown)) {
            array_push($this->format_errors, $comment_table_fields[12]);
        }

        if (is_null($updateCheck)) {
            array_push($this->missing_errors, $comment_table_fields[13]);
        } elseif (!is_numeric($updateCheck)) {
            array_push($this->format_errors, $comment_table_fields[13]);
        }

        if (is_null($updateReason)) {
            array_push($this->missing_errors, $comment_table_fields[14]);
        } elseif (!is_numeric($updateReason)) {
            array_push($this->format_errors, $comment_table_fields[14]);
        }
        $this->console_log("Missing errors is: " . json_encode($this->missing_errors));
        $this->console_log("Format errors is: " . json_encode($this->format_errors));
        return array($this->missing_errors, $this->format_errors);
    }

}
?>