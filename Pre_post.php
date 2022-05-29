<?php 
 include 'dbcon.php';
 session_start();
 //connessione con database
  $conn=mysqli_connect($dbcon['host'],$dbcon['user'],$dbcon['password'],$dbcon['name']) or die($conn);
    $userid=$_SESSION['id'];
    $post_id=$_POST['postid'];


    $in_query="INSERT INTO favorites(user, post) VALUES ($userid,$post_id)";
    //prendere il nuovo numero di post preferiti  dopo l'attivazione del trigger
    $oquery="SELECT npreferiti FROM users WHERE id=$userid ";

    $res = mysqli_query($conn,$in_query) or die('Unable to execute query. ').mysqli_error($conn);

    if($res){

        $res=mysqli_query($conn,$oquery);
        if(mysqli_num_rows($res)>0){

            $entry=mysqli_fetch_assoc($res);
            $returndata = array('ok' => true, 'npreferiti'=> $entry['npreferiti']);
            echo json_encode($returndata);
            mysqli_close($conn);

            exit;
        }
    }
    mysqli_close($conn);
    echo json_encode(array('ok'=> false));
?>