<?php
include 'api/include.php';
    $data=new user_agent;
    $data->store_query();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="index.css"/>
        <script src="index.js"></script>
    </head>
    <body>
        <div class="home-nav">
            <div>
                <div class="home-div">
                    <a href="index.php">Home</a>
                </div>
                <div class="home-search-items">
                    <form method="GET" action="search.php" >
                        <input class="search-box" type="search" name="search" placeholder="Search yourself..." autofocus="on" />
                        <button type="submit" id="search-btn">Search</button>
                        <a href="visit.php?who=random"><button type="button" class="btn">Random</button></a>
                    </form>
                </div>
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
