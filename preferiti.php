<?php 
   session_start();
    if(!isset($_SESSION['id'])){
        header("Location: login.php");
        exit;
    }
?>

<html >
<?php 
 include 'dbcon.php';
 //connessione con database
  $conn=mysqli_connect($dbcon['host'],$dbcon['user'],$dbcon['password'],$dbcon['name']) or die($conn);
    $userid=$_SESSION['id'];
    $query="SELECT* FROM users WHERE id='$userid'";
    $res_1=mysqli_query($conn,$query);
    $userinfo=mysqli_fetch_assoc($res_1);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./style/preferiti.css">
    <script src='./scripts/preferiti.js' defer></script>
    <title>Preferiti</title>
</head>

    <header> 
        <h1>Benvenuto  <?php echo $_SESSION['username'] ?>!</h1>
        <h2>So-Ball</h1>
    </header>

 <body>
    <header>
            <nav>
                <div id="nav">
                </div>

                <div class="l_nav">
                    <a href="./" >Home</a>
                    <a href="logout.php">Logout</a><br><br>
                </div>
                <div >
                    
                   <h1>I TUOI PREFERITI: </h1>
                </div> 

                <main class="fixed">
            <section id="profile">
                <div class="name">
                    Profilo Loggato: <br>
                    <?php 
                    
                        echo "nome: ", $userinfo['name'],"<br>"; 
                        echo "cognome: ",  $userinfo['surname']; 
                    
                    ?>
                </div>
                <div class="username">
                    username: @<?php echo $userinfo['username'] ?>
                </div>
                    <div class="stats" >
                        <br>
                        <a href="preferiti.php"><span class="count">Preferiti:
                        <?php echo $userinfo['npreferiti'] ?></span></a>
                        
                    </div>
                    <p><a href="logout.php">esci dal sito</a></p>

            </section> 
                
            </nav>
    </header>

    </main> 
        <section id="center">   
     
         </section>
        
    
</body>
</html>
<?php mysqli_close($conn); ?>
