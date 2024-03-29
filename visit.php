<?php
$check=0;
    include 'api/include.php';
    if($_GET['who']=="random"){
        $data=new random_roll;
        $result=json_decode($data->get_random());
    }
    else{
        $data=new user_agent;
        $data->check_new();
        $data->store_query();
        $result=json_decode($data->visit($_GET['who']));
    }
    if($_GET['count'] && $_GET['search']){
        $check=1;
        $f_count=$data->sql_filter($_GET['count']);
        $for_next=json_decode($data->search_result($_GET['search'],0,$f_count+2));
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="index.css"/>
    </head>
    <body>
        <div class="visitors">
            <span>Total visitors: <?=  file_get_contents("couNt")   ?></span>
        </div>
        <div class="nav-n-footer">
            <div class="main-search-nav">
                <div class="home-div">
                    <a href="index.php">Home</a>
                </div>
                <div class="home-search-items">
                    <form method="GET" action="search.php" >
                        <input class="search-box" type="search" name="search" placeholder="Search yourself..."/>
                        <button type="submit">Search</button>
                        <a href="visit.php?who=random"><button type="button" class="btn">Random</button></a>
                    </form>
                </div>
            </div>
            
        </div>

        <div class="profile-container">
            <div>
            <?php if($result){ ?>
                <div class="name"><?= $result[0] ?></div>
                <div class="image">
                    <img src="<?= strpos($result[1],'<>')?'no-pic.png':'http://<>/'.$result[1].'.jpg' ?>" alt="Student picture">
                </div>
                <div class="roll">Roll: <?= $result[1] ?></div>
                <div class="popular">Popularity: <?= $result[2] ?></div>
            <?php } 
                else{
                    echo "something is wrong!!";
                }
            ?>
            <div class="next-prev-div">
                <?php if($check==1 || $_GET['who']!="random"){ 
                    if($_GET['count']>1 && $for_next[$f_count-1][1]){    
                ?>
                    <a href="visit.php?who=<?= $for_next[$f_count-1][1]; ?>&search=<?=$_GET['search']?>&count=<?=$_GET['count']-1?>" id="prev"></a>
                <?php } else {
                    echo '<a href="#" id="prev" class="hidden"></a>';
                }
                    if($for_next[$f_count+1][1]){
                ?>
                <a href="visit.php?who=<?= $for_next[$f_count+1][1]; ?>&search=<?=$_GET['search']?>&count=<?=$_GET['count']+1?>" id="next"></a>
            <?php
                    } 
                } 
                else if($_GET['who']=="random"){
                    ?>
                    <a href="#" id="prev" class="hidden"></a>
                    <a href="visit.php?who=random" id="next"></a>
            <?php } ?>
            </div>
            </div>
            
        </div>
    </body>
</html>
