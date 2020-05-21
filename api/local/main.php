<?php
include '../include.php';
$data=new main_get_data;
    if($_GET['search']){
        echo $data->search_result($_GET['search']);
    }
    else if($_GET['who']){
        echo $data->visit($_GET['who']);
    }
?>