<?php
    require_once 'MyDBControllerMySQL.class.php';
class Pager
{
    //------------
    // 属性
    //------------

    // DB Controller
    var $db_controller;

    // Ints
    var $items_per_page = 30;
    var $current_page;
    var $total_count;
    var $num_pages;

    // Bools
    var $can_go_back;
    var $can_go_forward;

    //------------
    // 操作
    //------------
    // コンストラクタ(DB接続)
    function __construct($cur_page) {
        $this->db_controller = new MyDBControllerMySQL();
        $this->db_controller->connect();
        $table_name = "kadai_jonathan_ziplist";
        $total_pages_sql = "SELECT COUNT(*) FROM $table_name";
        $allDataArray = $this->db_controller->query($total_pages_sql, null, null, null);
        $this->total_count = $allDataArray[0]["COUNT(*)"];
        $this->num_pages = ceil($this->total_count / $this->items_per_page);
        if ($cur_page == 0) {
            $this->can_go_back = false;
            $this->can_go_forward = true;
            $this->console_log($this->can_go_forward);
        } elseif ($cur_page == $this->num_pages - 1) {
            $this->can_go_back = true;
            $this->can_go_forward = false;
        } else {
            // We're somewhere in the middle
            $this->can_go_back = true;
            $this->can_go_forward = true;
        }
        $this->db_controller->close();
    }

    // デストラクタ(DB切断)
    function __destruct() {
    }

    function console_log($data)
    {
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

}
?>