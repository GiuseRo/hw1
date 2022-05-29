<?php 
 include 'dbcon.php';
 session_start();
 //connessione con database
  $conn=mysqli_connect($dbcon['host'],$dbcon['user'],$dbcon['password'],$dbcon['name']) or die($conn);
    $userid=$_SESSION['id'];
    $post_id=$_POST['postid'];

    $iquery="DELETE FROM likes WHERE post=$post_id AND user=$userid";
    //prendere il nuovo numero di like dopo l'attivazione del trigger
    $oquery="SELECT nlikes FROM posts WHERE id=$post_id ";

    $res = mysqli_query($conn,$iquery) or die('Unable to execute query. ').mysqli_error($conn);

    if($res){

        $res=mysqli_query($conn,$oquery);
        if(mysqli_num_rows($res)>0){

            $entry=mysqli_fetch_assoc($res);
            $returndata = array('ok' => true, 'nlikes'=> $entry['nlikes']);
            echo json_encode($returndata);
            mysqli_close($conn);

            exit;
        }
    }
    mysqli_close($conn);
    echo json_encode(array('ok'=> false));
?>