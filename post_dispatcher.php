<?php
        include 'dbcon.php';
        header('Content-Type: application/json');
        
        session_start();
        if(!isset($_SESSION['id'])){
            header("Location: login.php");
            exit;
        }
             $userid=$_SESSION['id'];
             
             $url=$_POST['squadra'];
             $anno=$_POST['anno'];
             $v=$_POST['vittorie'];
             $p=$_POST['sconfitte'];
             $d=$_POST['pareggi'];
             $posizione=$_POST['posizione'];
             $punti=$_POST['punti'];
             $gf=$_POST['goal_fatti'];
             $Gs=$_POST['goal_subiti'];
             $dif=$_POST['differenza'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER  , true);
        curl_setopt($ch, CURLOPT_NOBODY  , true);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        $status = curl_getinfo ($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);    

        if ($status == 200) {
            $conn = mysqli_connect($dbcon['host'], $dbcon['user'], $dbcon['password'], $dbcon['name']);
            
            $userid = mysqli_real_escape_string($conn, $userid);
            $v=mysqli_real_escape_string($conn,$_POST['vittorie']);
            $p=mysqli_real_escape_string($conn,$_POST['sconfitte']);
            $d=mysqli_real_escape_string($conn,$_POST['pareggi']);
            $posizione=mysqli_real_escape_string($conn,$_POST['posizione']);
            $punti=mysqli_real_escape_string($conn,$_POST['punti']);
            $gf=mysqli_real_escape_string($conn,$_POST['goal_fatti']);
            $Gs=mysqli_real_escape_string($conn,$_POST['goal_subiti']);
            $dif=mysqli_real_escape_string($conn,$_POST['differenza']);
           $anno= mysqli_real_escape_string($conn,$anno);
            $url = mysqli_real_escape_string($conn, $url);

           $query = "INSERT INTO posts(user, content) VALUES('.$userid.', JSON_OBJECT('url', '$url','anno', '$anno','posizione','$posizione','vittorie','$v ','sconfitte','$p ','pareggi','$p ','punti','$punti ','goal_fatti','$gf ','goal_subiti','$Gs','differenza','$dif '))"; 

            if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
                echo json_encode(array('ok' => true));
                exit;
            }   
        }
        echo json_encode(array('ok' => false));
    ?>