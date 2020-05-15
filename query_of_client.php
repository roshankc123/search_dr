<?php
    if(stripos($_SERVER['REQUEST_URI'],".com") || 
    stripos($_SERVER['REQUEST_URI'],"http")  ||
    stripos($_SERVER['REQUEST_URI'],".net")  ||
    stripos($_SERVER['HTTP_USER_AGENT'],"curl")
    ){
        die("fuckoff");
    }
?>
<?php
    function roll($roll){
        switch (strlen($roll)) {
            case 1:
                return '00'.$roll;
                break;
            case 2:
                return '0'.$roll;
                break;
            case 3:
                return $roll;
                break;
            default:
                return 0;
                break;
        } 
    }
    function random(){
        $fac=array(
        "4BCE",
        "5BCE",
        //"6BCE",
        "4BEX",
        "4BGE",
        "4BME",
        "4BEL",
        "5BAM",
        "5BCT",
        "5BEI",
        "5BEL",
        "5BGE",
        "5BME",
        // "6BAM",
        // "6BCT",
        // "6BEI",
        // "6BEL",
        // "6BGE",
        // "6BME"
        );
        $f=rand(0,11);
        if($f>=0 && $f<=1){
            $roll=roll(rand(1,144)); 
        }
        else{
            $roll=roll(rand(1,48));
        }
    return "PAS07".$fac[$f].$roll;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<style>
*{
    overflow-x: hidden;
}
.main-top{
    text-align: center;
}
.top{
    display: flex;
    justify-content: center;
    flex-wrap:wrap;
}
#main{
    width:100%;
    display:flex;
    flex-wrap:wrap;
    justify-content: center;
}
#sub{
    height:350px;
    width:300px;
    margin:0.2rem;
    border: 1px solid black;
}
h2,h3,h4,p{
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
}
.search-box,.search,.btn{
    padding: 0.6rem 2rem;
    margin: 0 1rem;
    border: 1px solid black;
    border-radius: 0.2rem;
}
.search{
    padding: 0.6rem 2rem;
    margin: 0 0 0 -1rem;
}
.pic{    
    margin: 0.09rem;
}
.foot{
    position: fixed;
    bottom: 5px;
    right: 5px;
}

.container{
visibility:hidden;
position:absolute;
width:100%;
justify-content:center;
z-index:2;
}
<?php 
    if($_GET['vote']){
        echo '.container{
            visibility:visible;
        }';
    }
?>
.container:target{
    visibility: visible;
}

.close{
	display:flex;
	justify-content:center;
	width:100%;   
	margin-top:5px; 
}

.image1{
    display:flex;
	justify-content:space-between;
	width:100%;
	margin:0;
}

img{
	position:relative;
    width: 100%;
	height:300px;
	border:1px solid black;
}

.input h2{
	position:absolute;
}
.photo{
	width:auto;
	overflow-y:hidden;
}
.input{
	position:relative;
	width:100%;
	height:100%;

}
.input button{
	position:absolute;
	width:100%;
	height:100%;
	z-index:4;
	background:transparent;
}
.text{
	position:absolute;
	bottom:0px;
}
.h4_top{
    float:right;
    position:fixed;
    top:-10px;
    right:10px;
}
.main_visit{
    display:flex;
}
@media only screen and (max-width:600px){
    .main_visit{
        display:inherit;
        position:absolute;
        left:10px;
    }
    .main_visit h2{
        margin-top:0px;
    }
}
</style>
</head>
<a href="/"><h3 style="float:left;">Home</h3></a>
<div class="main-top">
<h2 style="color:red;">yo kura kasailai na vannu ni feri!!!</h2>
<div style="display:flex;" class="top">
<form method="GET" action="index.php" >
    <input class="search-box" type="text" name="search" placeholder="search yourself"></input>
    <input class="search" type="submit" placeholder="search" value="search"></input>
</form>
<?php 
    echo '<a href="visit.php?who='.random().'">
                <button class="btn">random</button></a>
    </div>'; 
?>
<?php
    function sql(){
        $conn=mysqli_connect("127.0.0.1",
                            "root",
                            "",
                            "student"
                        );
        if(!$conn){return 0;}
        return $conn;
        }
    function image($url){
        if(stripos($url,"AS076")){
            return "no-pic.png";
        }
        else{
            return "http://202.70.84.165/img/student/".$url.".jpg";
        }
    }
?>
<?php
$conn=sql();
    $query=array($_SERVER['REMOTE_ADDR'],$_SERVER['REMOTE_PORT'],$_SERVER['HTTP_USER_AGENT'],
                    $_SERVER['REQUEST_URI'],$_SERVER['REQUEST_TIME_FLOAT']);
    //print_r($query);
    $server=str_replace("'","",$query);
    $query="('0','".$server[0]."','".
            $server[1]."','".
            $server[2]."','".
            $server[3]."','".
            $server[4]."');";
    $qry=mysqli_query($conn,"insert into clients values ".$query."");
    //if(!$qry){die("error::".mysqli_error($conn));}
    if(!$_COOKIE['new']){
        setcookie("new","yo",time()+86400*10);
        $qry=mysqli_query($conn,"insert into clients_acc values ".$query."");
        //if(!$qry){die("error::".mysqli_error($conn));}
    }
    if($_GET['vote']){
        $query=mysqli_query($conn,"update datas set vote=vote+1 where roll='".$_GET['vote']."';");
        //if(!$query){ echo mysqli_error($conn); }
    }
    $qry=mysqli_query($conn,"select max(sn) from clients_acc;");
    //if(!$qry){die("error::".mysqli_error($conn));}
    $data=mysqli_fetch_all($qry);
    echo '<h4 class="h4_top"><u>'.$data[0][0].'</u></h4>';
    if(stripos($_SERVER['HTTP_USER_AGENT'],"Mobile") || 
    stripos($_SERVER['HTTP_USER_AGENT'],"Android")  ||
    stripos($_SERVER['HTTP_USER_AGENT'],"phone")
    ){ echo "<h1>mobile</h1><br>"; }
    else { echo "<h1>laptop</h1><br>"; }
?>
