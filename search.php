<?php
    include 'api/include.php';
    $data=new user_agent;
    if($_GET['search']){
        $data->check_new();
        $data->store_query();
        if($_GET['offset']){
            $result=json_decode($data->get_more(1));
        }
        else{
            $result=json_decode($data->search_result($_GET['search']));
        }
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
                        <button type="submit" id="search-btn">Search</button>
                        <a href="visit.php?who=random"><button type="button" class="btn">Random</button></a>
                    </form>
                </div>
            </div>
            <!-- <div class="foot">
                <div> 
                    By using this site you agreed this data doesnt affect anything
                </div>
                <span>&times;</span>
            </div>  -->
        </div>

        <div class="search-container">
            <div class="result-status">
                <?php if($result[0][1]==0)echo "No"; else echo $result[0][1]; ?> results found
            </div>
            <div class="search-result">
                <?php
                    $i=1;
                    while($result[$i]){
                        $image=strpos($result[$i][1],'<>')?'no-pic.png':'<>'.$result[$i][1].'.jpg';
                        echo '<a href="visit.php?who='.$result[$i][1].'&search='.$_GET['search'].'&count='.$i.'" class="each-card">
                                <div class="back-img" style="background-image: url(\''.$image.'\');"></div>
                                <div class="roll"># '.$result[$i][1].'</div>
                                <div class="name">'.$result[$i][0].'</div>
                            </a>';
                        $i++;
                    }
                ?>
            </div>
            <?php
                $offset=($_GET['search'] && $_GET['offset'])?$_GET['offset']:0;
                $offset+=20;
                if($result[0][1]>$offset){
                    echo "
                    <div class='more-div'>
                        <a href='search.php?search={$_GET['search']}&offset={$offset}' id='more'>More</a>
                    </div>";
                }
            ?>
        </div>
    </body>
</html>
