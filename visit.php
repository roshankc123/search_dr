</div>
<?php
include 'query_of_client.php';
    if($_GET['who']==""){
        $conn=sql();
        $who=str_replace(array("'","\"","/","\\",";"),"",$_GET['who']);
        $i=1;
        $qry=mysqli_query($conn,"select name,roll,visit from `datas` 
                            where roll='".$who."'
                            ;");
        //if(!$qry){die("error::".mysqli_error($conn));}
        $data=mysqli_fetch_all($qry);
        ////////////////////////to increase count
        $qry=mysqli_query($conn,"update `datas` set visit='".($data[0][2]+1)."'               
                            where roll='".$who."'
                            ;");
        //if(!$qry){die("error::".mysqli_error($conn));}
        $image=image($data[0][1]);
        echo '<div class="main_visit"><div style="height:310px;min-width:300px;max-width:300px;">
            <img src="'.$image.'" /></div><div>
        ';
        echo "<h2>name:".$data[0][0].
        "<br>roll:".$data[0][1].
        "<br>ops ".$data[0][2].' times polpular</h2></div></div>';
    	mysqli_close($conn);
	}
?>
