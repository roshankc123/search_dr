<?php
    include 'api/include.php';
    if($_GET['who']=="random"){
        $data=new random_roll;
        $result=json_decode($data->get_random());
    }
    else{
        $data=new main_get_data;
        $result=json_decode($data->visit($_GET['who']));
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
                    <img src="<?= strpos($result[1],'AS076')?'no-pic.png':'http://202.70.84.165/img/student/'.$result[1].'.jpg' ?>" alt="Student picture">
                </div>
                <div class="roll">Roll: <?= $result[1] ?></div>
                <div class="popular">Popularity: <?= $result[2] ?></div>
            <?php } 
                else{
                    echo "something is wrong!!";
                }
            ?>
            </div>
        </div>

    </body>
</html>
