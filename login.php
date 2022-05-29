<?php 
include 'dbcon.php';
session_start();
if(isset($_SESSION['username'])){
    header("Location: home.php");
    exit;
}

//controllo che esista un utente con quelle credenziali
if(isset($_POST['username'])&&isset($_POST['password'])){
    $conn=mysqli_connect($dbcon['host'],$dbcon['user'],$dbcon['password'],$dbcon['name']) or die(mysqli_error($conn));

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password  = mysqli_real_escape_string($conn,$_POST['password']);

    $query="SELECT id,username,password FROM users WHERE username = '$username'";   
    $res= mysqli_query($conn,$query)or die(mysqli_error($conn));
    if(mysqli_num_rows($res)>0){
        $entry =mysqli_fetch_assoc($res);
        if(password_verify($_POST['password'], $entry['password'])){
            //imposto una  della sessione
            $_SESSION["username"]=$entry['username'];
            $_SESSION["id"]=$entry['id'];
            header("Location: home.php");
            mysqli_free_result($res);
            mysqli_close($conn);
            exit;
        }else
        $errore="password errata";
     } else
           $errore="username non registrato";
   if(empty($_POST['username'])||empty($_POST['password']))
    $errore="compila entrambi i campi";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="./style/login.css">

        <title>FOOTBALL accedi</title>
    </head>

    <body>
    <h1>ACCESSO AL SITO</h1>
    <main class=login>
    <form method="post">
      <label>Nome Utente: <input type='text' name='username'<?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>></label>
      <label>Password: <input type='password' name='password'></label>
      <label>&nbsp;<input type='submit'value="entra"></label>
      <?php 
         //verifico la presenza di errori
            if(isset($errore)){
               echo "<span class='error'>$errore</span>";
            }
            echo"<br>";
        ?>
      <a href="registrazione.php">non hai un accont? crealo!</a>
    </form>
    </main>
    
    </body>
</html>