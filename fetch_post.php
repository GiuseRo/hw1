<?php
    include 'dbcon.php';
    session_start();

    header('Content-Type: application/json');
    $userid=$_SESSION['id'];
    $con=mysqli_connect($dbcon['host'],$dbcon['user'],$dbcon['password'],$dbcon['name']) or die($conn);
    
    $query = "SELECT users.id AS userid, users.name AS name, users.surname AS surname, users.username AS username,
    posts.id AS postid, posts.content AS content, posts.time AS time, posts.nlikes AS nlikes, EXISTS(SELECT user FROM favorites WHERE post = posts.id AND user = $userid) AS favorited,
    EXISTS(SELECT user FROM likes WHERE post = posts.id AND user = $userid) AS liked 
    FROM posts JOIN users ON posts.user = users.id  ORDER BY postid DESC";


    $res=mysqli_query($con,$query) or die(mysqli_error($con));

    $postArray=array();
    while($entry=mysqli_fetch_assoc($res)){
        $time = getTime($entry['time']);
        $postArray[]=array('userid' => $entry['userid'], 'name' => $entry['name'], 'surname' => $entry['surname'], 
        'username' => $entry['username'],'postid' => $entry['postid'], 'content' => json_decode($entry['content']),
        'nlikes' => $entry['nlikes'],'time' => "$time", 'liked' => $entry['liked'],'preferito' => $entry['favorited']);
       }
    echo json_encode($postArray);
    exit;

function getTime($timestamp) {      
    // Calcola il tempo trascorso dalla pubblicazione del post       
    $old = strtotime($timestamp); 
    $diff = time() - $old;           
    $old = date('d/m/y', $old);

    if ($diff /60 <1) {
        return intval($diff%60)." secondi fa";
    } else if (intval($diff/60) == 1)  {
        return "Un minuto fa";  
    } else if ($diff / 60 < 60) {
        return intval($diff/60)." minuti fa";
    } else if (intval($diff / 3600) == 1) {
        return "Un'ora fa";
    } else if ($diff / 3600 <24) {
        return intval($diff/3600) . " ore fa";
    } else if (intval($diff/86400) == 1) {
        return "Ieri";
    } else if ($diff/86400 < 30) {
        return intval($diff/86400) . " giorni fa";
    } else {
        return $old; 
    }
}
?>