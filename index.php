
<?php
//include 'query_of_client.php';
$conn=sql();
if($_GET['search']){
	echo "<h3>click on photo to visit</h3></div>";
    $search=str_replace(array("'","\"","/","\\",";"),"",$_GET['search']);
    $string=explode(" ",$search);
    $i=0;
    $find="";
    $pec="";
    while($string[$i]){
        $find=$find."name like '%".$string[$i]."%' or ";
        $total.=$string[$i]." ";
        // $p=0;
        // $rec="";
        // while($string[$i+1] && $p<strlen($string[$i+1])){
        //     $rec.=$string[$i+1][$p];
        //     $pec=$string[$i]." ".$rec;
        //     echo $pec."<br>";
        //     $p++;
        // }
        // echo $total."<br>";
        $i++;
    }
    $i=1;
    echo $find;
    $qry=mysqli_query($conn,"select name,roll from `datas` 
                            where name like '%".$search."%' or
                            ".$find."
                            roll like '%".$search."%'
                            order by if(strcmp('".$search."',left(name,'".strlen($search)."'))=0,0,1) asc,visit desc limit 20;");
                            //if(!$qry){die("error::".mysqli_error($conn));}
                            $data=mysqli_fetch_all($qry);
    //if(!$data){echo "<p><br>enter valid info</p>";}
    $i=0;
    echo '<div id="main">';
    while($data[$i] || $i<=10){
    $image=image($data[$i][1]);
    echo '<a href="visit.php?who='.$data[$i][1].'#">
        <div id="sub" style="background:url('.$image.'+q);">
                '.$data[$i][0].'
        </div>
        </a>';
    $i++;
    }
    echo "</div>";
	mysqli_close($conn);
}
else{
    echo 'start with you name or friends one of wrc<br>';
}
?> 
<div class="foot">
<p> by using this site you agreed this data doesnt affect anything
</p>
</div>
<?php if(!$_GET['search'] && !$_GET['who']){ ?>
<a href="#popup" id="targeter"><button>
        Game
    </button></a>
<?php 
if($_GET['vote']){
    $a=$_GET['vote'];
}
else{
    $a=random();
}
    $b=random();
    $query=mysqli_query($conn,"select a.name,b.name from datas a,datas b where a.roll='".$a."' and b.roll='".$b."';");
    //if(!$query){die("error fetching"); }
    $data=mysqli_fetch_all($query);
    //print_r($data);
?>
<div class="container" id="popup">
    <div class="close">
        <a  href="index.php"><button>CloseGame</button></a>
    </div>
    <br>
	<p style="margin-top:0px;">Click on photo to vote</p>    
	<div class="image1">
        <div class="photo">
	        <div class="input">
                <form method="GET" action="index.php">
                    <input type="hidden" value="<?php echo $a;?>" name="vote"></input>
				    <button><h3><?php echo $data[0][0]; ?></h3></button>
		        </form>
	            <img src="http://202.70.84.165/img/student/<?php echo $a; ?>.jpg" alt="pic">
	        </div>
        </div>
        <div class="photo">
	        <div class="input">
                <form method="GET" action="index.php">
                    <input type="hidden" value="<?php echo $b; ?>" name="vote"></input>
				    <button><h3><h3><?php echo $data[0][1]; ?></h3></button>
		        </form>
	            <img src="http://202.70.84.165/img/student/<?php echo $b; ?>.jpg" alt="pic">	
	        </div>
        </div>
    </div>
</div>
<?php } ?>
</body>
</html>