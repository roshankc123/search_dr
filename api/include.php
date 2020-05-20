<?php
    class local_global{
        function sql_connect(){
            $conn=mysqli_connect("127.0.0.1",
                                    "root",
                                    "",
                                    "student"
                                );
            if(!$conn){die("error connecting");}
            return $conn;
        }
        function sql_filter($raw){
            $proceed=str_replace(array("'","\"","/","\\",";"),
                                    array("&qot",'&dqot',"&bsh","&fsh","&coln")
                                    ,$raw);
            return $proceed;
        }
    }

    class main_get_data extends local_global{
        public $search="";
        public $sql="";
        function main_get_data(){
            $this->sql=$this->sql_connect();
            // if($_GET['search']){
            //     $this->search=$this->sql_filter($_GET['search']);
            // }
            // else if($_GET['who']){
            //     $this->search=$this->sql_filter($_GET['who']);
            // }
        }

        function search_result($r_search){
            $this->search=$this->sql_filter($r_search);
            $search_array=explode(" ",$this->search);
            $i=0;
            $find="";
            while($search_array[$i]){
                $find.="name like '%".$search_array[$i]."%' or ";
                $i++;
            }
            $common_qry="where name like '%".$this->search."%' or
                        ".$find."
                        roll like '%".$this->search."%'";  ///2000 if=s for desc and name is search string to remain that count on top of array
            $qry=mysqli_query($this->sql,"select '".$this->search."' as name,count(name) as roll,2000 as visit from datas ".$common_qry."   
                            union select name,roll,visit from `datas` ".$common_qry." 
                            order by if(strcmp('".$this->search."',left(name,'".strlen($this->search)."'))=0,0,1) asc,
                            visit desc limit 20;");
            if(!$qry){die("error::".mysqli_error($this->sql));}
            return json_encode(mysqli_fetch_all($qry));
        }
        function visit($r_visit){
            $this->search=$this->sql_filter($r_visit);
            $qry=mysqli_query($this->sql,"select name,roll from `datas` 
                            where roll='".$this->search."' limit 1;");
            if(!$qry){die("error::".mysqli_error($this->sql));}
            return json_encode(mysqli_fetch_all($qry)[0]);
        }
    }

    class random_roll extends main_get_data{
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
                $roll=$this->roll(rand(1,144)); 
            }
            else{
                $roll=$this->roll(rand(1,48));
            }
        return $this->visit("PAS07".$fac[$f].$roll);
        }
    }
?>