<?php
include '../include.php';
    if($_GET['search']){
        $data=new user_agent;
        $data->check_new();                ////check for new user or not
        //$data->store_query();
        if($_GET['offset']){
            echo $data->get_more(0);        ///for more result of search
        }
        else{
            echo $data->search_result($_GET['search']);   ///initilize a search
        }
    }
    else if($_GET['who']){
        if($_GET['who']=="random"){
            $data=new random_roll;
            echo $data->get_random();                    ////for random users
        }
        else{
            $data=new user_agent;
            $data->check_new(); 
            //$data->store_query();
            echo $data->visit($_GET['who']);                ////to visit a profile
        }
    }
?>