<?php
include '../include.php';
    if($_GET['search']){
        $data=new user_agent;
        $data->check_new();
        //$data->store_query();
        if($_GET['offset']){
            echo $data->get_more(0);
        }
        else{
            echo $data->search_result($_GET['search']);
        }
    }
    else if($_GET['who']){
        if($_GET['who']=="random"){
            $data=new random_roll;
            echo $data->get_random();
        }
        else{
            $data=new user_agent;
            $data->check_new();
            $data->store_query();
            echo $data->visit($_GET['who']);
        }
    }
?>