<?php
    $conn=mysqli_connect("127.0.0.1","root","","student");
    if(!$conn){ die(mysqli_connect_error());}
    $json=json_decode(file_get_contents("sql.json"));
    $i=0;
    $insert="";
    while($json[$i]){
        $insert.="(0,'".$json[$i][0]."','".$json[$i][1]."','".$json[$i][2]."'),";
        $i++;
    }
    $insert.="(0,'','',0)";
    $qry=mysqli_query($conn,"insert into datas values ".$insert.";");
    if(!$qry){ die(mysqli_error($conn));}
    else{ echo "data added to database";}
    // $qry=mysqli_query($conn,"select name,roll,visit from datas;");
    // $data=json_encode(mysqli_fetch_all($qry));
    // echo file_put_contents("sql.json",$data);
?>