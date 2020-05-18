<?php
    include 'api/include.php';
    $a=new main_get_data;
    $_GET['search']="roshan";
    $_GET['who']="PAS075BCT035";
    print_r(json_decode($a->search_result()));
    echo $a->visit();
?>