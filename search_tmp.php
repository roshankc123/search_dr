<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="index.css"/>
    </head>
    <body>
        <div class="main-search-nav">
            <div class="home-div">
                <a href="index_tmp.php">Home</a>
            </div>
            <div class="home-search-items">
                <form method="GET" action="search_tmp.php" >
                    <input class="search-box" type="search" name="search" placeholder="Search yourself..."/>
                    <button type="submit">Search</button>
                    <a href="visit_tmp.php?who="><button type="button" class="btn">Random</button></a>
                </form>
            </div>
        </div>
        <div class="foot">
            <div> 
                By using this site you agreed this data doesnt affect anything
            </div>
            <span>&times;</span>
        </div> 
    </body>
</html>


<!--
    
<?php 
    echo '<a href="visit_tmp.php?who=">
                <button class="btn">random</button></a>
        </div>'; 
?>
<?php
    $i=0;
    echo '<div id="main">';
    while($i<=10){
        $image="img";
        echo '<a href="visit_tmp.php?who=roll'.$i.'#">
            <div id="sub" style="background:url('.$image.');">
                    name'.$i.'
            </div>
            </a>';
        $i++;
    }
    echo "</div>";
?>
->