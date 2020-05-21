<?php
include '../include.php';
    if($_GET['search']){
        $data=new user_agent;
        //$data->store_query();
        echo $data->search_result($_GET['search']);
    }
    else if($_GET['who']){
        if($_GET['who']=="random"){
            $data=new random_roll;
            echo $data->get_random();
        }
        else{
            $data=new user_agent;
            //$data->store_query();
            echo $data->visit($_GET['who']);
        }
    }
?>