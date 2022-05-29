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

    <link rel="stylesheet" href="./style/home.css">
    <script src='./scripts/home.js' defer></script>

    <title>UAAA il SITOO</title>
</head>

    <header class='ben'> 
        <h1>Benvenuto  <?php echo $_SESSION['username'] ?>!</h1>
        <h2>Social-Ball</h1>
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
                <div class="s_nav">

                    
                   <button id="condividi">condividi squadra</button>
                </div> 
                <form class='hidden' autocomplete="off">
                <label>ANNO: <select id='anno' name='anno'>
                        <option value="2021">2021-2022</option>
                        <option value="2020">2020-2021</option>
                        <option value="2019">2019-2020</option>
                        <option value="2018">2018-2019</option>
                        <option value="2017">2017-2018</option>
                        <option value="2016">2016-2017</option>
                        <option value="2015">2015-2016</option>
                        <option value="2014">2014-2015</option>
                        <option value="2013">2013-2014</option>
                        <option value="2012">2012-2013</option>
                        <option value="2011">2011-2012</option>
                        <option value="2010">2010-2011</option>
                        </select>
                    </label>       
                <label ><h3 >cerca la squadra da condividere </h3></label>
                        <label>Campionato: <select id='campionato' name='campionato'>
                        <option value="ita.1">Serie A</option>
                        <option value="eng.1">Premier League</option>
                        <option value="esp.1">Liga spagnola</option>
                        <option value="fra.1">Ligue</option>
                        <option value="ger.1">Bundesliga</option>
                        </select>
                    </label>

                    <label >Squadra:<input id="squadra" type="text" name=squadra></label>
                    <label id='invio'>&nbsp;<input class='submit' type='submit'value="cerca"></label>
                    <div ><button>nascondi ricerca</button></div>
                </form>
                
            </nav>
    </header>

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
            
          
        </main> 
        <section id="center">   
        <div id='nuovo'></div>
         </section>
        
    
</body>
</html>
<?php mysqli_close($conn); ?>