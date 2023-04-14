<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="funzioni.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="stile.css" type="text/css"/> 
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <title>Screener</title>
    
</head>
<body class="home">
    <?php       
        //inizio sessione
        session_start();
    ?>
    <div class="row">
    <div class="col-3">
        <img src="./img/candlestick1.PNG" class="img1a" id="img1a"></img>
        <img src="./img/walletimg.PNG" class="img2a" id="img2a"></img>
    </div>
    <div class="grid col-6">
        <h1>SCREENER</h1>
        <a class="btn btn-outline-warning btn-lg" href="screener.php" id="hScreener">SCREENER</a>
        <?php
        //controllo se è stato effettuato il login e inseirsco tag diversi a seconda di ciò
        if(!isset($_SESSION['utente'])){
            echo '<a class="btn btn-outline-warning btn-lg disattivato hovertext" data-hover="Per accedere al wallet,devi prima
            effettuare il Login">WALLET</a>';
            echo"<a id='btn3' class='btn btn-outline-warning btn-lg' href='login.html'>LOGIN</a>";
        }else{
            echo '<a class="btn btn-outline-warning btn-lg" href="wallet.php" id="hWallet">WALLET</a>';
            echo"<a id='btn3' class='btn btn-outline-warning btn-lg' href='logout.php'>LOGOUT</a>";
        }
    ?>
    </div>
    <div class="col-3">
        <img src="./img/candlestick2.PNG" class="img1b" id="img1b"></img>
        <img src="./img/coin.PNG" class="img2b" id="img2b"></img>
    </div>  
    </div>
    <!-- inserimento immagini al passaggio del mouse sopra i pulsanti -->
    <script>
        $(document).ready(function(){
            $('#img1a').hide();
            $('#img1b').hide();
            $('#img2a').hide();
            $('#img2b').hide();
            $('#hScreener').mouseover(function(){
                if(parseInt(window.innerWidth)>1300){
                    $('#img1a').fadeIn(0);
                    $('#img1b').fadeIn(0);
                }
            })
            $('#hScreener').mouseleave(function(){
                $('#img1a').fadeOut(0);
                $('#img1b').fadeOut(0);
            })
            $('#hWallet').mouseover(function(){
                if(parseInt(window.innerWidth)>1300){
                    $('#img2a').fadeIn(0);
                    $('#img2b').fadeIn(0);
                }
            })
            $('#hWallet').mouseleave(function(){
                $('#img2a').fadeOut(0);
                $('#img2b').fadeOut(0);
            })
        })
    </script>
</body>
</html>