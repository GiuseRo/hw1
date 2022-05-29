<?php 
include 'dbcon.php';
//controllo validità dei campi
session_start();
if(!empty($_POST['username'])&& !empty($_POST['password'])
    && !empty($_POST['email'])&& !empty($_POST['name'])
    &&!empty($_POST['surname'])&& !empty($_POST['confirm_password']))
    {
        $error=array();
        $conn=mysqli_connect($dbcon['host'],$dbcon['user'],$dbcon['password'],$dbcon['name']) or die(mysqli_error($conn));
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/',$_POST['username'])){
           $error[]="Username non valido";
  
        }
        else{
            $username = mysqli_real_escape_string($conn,$_POST['username']);
            $query="SELECT username FROM users WHERE username = '$username'";
            $res=mysqli_query($conn,$query);
            if(mysqli_num_rows($res)>0){
                $error[]="username gia esistente";
              
            }
        }
        if(strlen($_POST['password'])<6){
            $error[]="password non abbastanza lunga";
        }
        if(strcmp($_POST['password'],$_POST['confirm_password'])!=0){
            $error[]="le password non coincidono";
           
        }
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            $error[]="email non valida";
        }else{
            $email = mysqli_real_escape_string($conn,$_POST['email']);
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }
        if(count($error)==0){
            $name=mysqli_real_escape_string($conn,$_POST['name']);
            $surname=mysqli_real_escape_string($conn,$_POST['surname']);
            
            $password=mysqli_real_escape_string($conn,$_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query="INSERT INTO users(username,password,name,email,surname,npreferiti)VALUES('$username','$password','$name','$email','$surname',0)";

        if( mysqli_query($conn,$query)){
            $_SESSION['username']=$username;
            $_SESSION['id']=mysqli_insert_id($conn);
            mysqli_close($conn); 
            header('Location: home.php');
          exit;
             }
             else{
                $error[] = "Errore di connessione al Database";
             }
         }
         mysqli_close($conn);
    }
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }
?>


<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="./style/registrazione.css">
        <script src='./scripts/registrazione.js' defer></script>

        <title>Registrazione in corso</title>
    </head>

    <body>
    
    <h1>REGISTRATI AL SITO</h1>
    <main class=registrazione>
    <form method="post">
      <label class='email'>E-mail: <input type='text' name='email'<?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>></label>
      <label class='name'>Nome : <input type='text' name='name'<?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?>></label>
      <label class='surname'>Cognome: <input type='text' name='surname'<?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?> ></label>
      <label class='username'>Nome Utente: <input type='text' name='username'<?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>></label>
      <label class='password'>Password: <input type='password' name='password'></label>
      <label class='confirm_password'>Conferma Password: <input type='password' name='confirm_password'></label>
      <label>&nbsp;<input type='submit'value="registrati"></label>
      <a href="login.php"> hai un accont? accedi!</a>
    </form> 
    </main>
     
         <div class="errorec">
    <div><span class="erroreemail"></span></div>
    <div><span class="errorename"></span> </div>
    <div><span class="erroresurname" ></span></div>
    <div><span class="erroreusername"></span></div>
    <div><span class="errorepassword"></span></div>
    <div><span class="erroreconfirm"></span></div>
        </div>
        <div class="errore"> 
        <?php 
        //verifico la presenza di errori
        if(isset($error)){
            echo "errore nella compilazione,elenco errori:";
            echo"<br>";
            foreach($error as $x => $x_value) {
                echo  $x_value;
                echo "<br>";
                }
        }
        ?>
        </div>
  
    </body>
</html>