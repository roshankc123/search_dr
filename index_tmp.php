<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css"/>
</head>
<body>
<a href="indes_tmp.php"><h3 style="float:left;">Home</h3></a>
<div class="main-top">
<h2 style="color:red;">yo kura kasailai na vannu ni feri!!!</h2>
<div style="display:flex;" class="top">
<form method="GET" action="index_tmp.php" >
    <input class="search-box" type="text" name="search" placeholder="search yourself"></input>
    <input class="search" type="submit" placeholder="search" value="search"></input>
</form>
<?php 
    echo '<a href="visit_tmp.php?who=">
                <button class="btn">random</button></a>
        </div>'; 
?>
<div class="foot">
<p> by using this site you agreed this data doesnt affect anything
</p>
</div>
</body>
</html>
