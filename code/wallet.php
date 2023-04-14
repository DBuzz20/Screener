<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="funzioni.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="stile.css" type="text/css"/> 
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <title>wallet</title>
</head>
<body class="home text-white" >
    <?php
        //inizio sessione       
        session_start();
    ?>
    <!-- creazione navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0">
        <div class="container-fluid">
            <div>
                <a class="navbar-brand " href="index.php" ><img src="./img/logo.PNG" class="logo"> Home Page</img></a>   
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcontent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarcontent">
                <ul class="navbar-nav ms-md-auto " >
                    <?php
                        if(!isset($_SESSION['utente'])){
                            echo"<li class='nav-item m-2'><a href='login.html' class='link-light'>Login</a></li>";  
                        }else{ 
                            echo"<li class='nav-item dropdown'> 
                                    <a class='nav-link dropdown-toggle' type='button' id='dropDownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>";
                                         echo $_SESSION['utente'];
                                    echo "</a>
                                <ul class='dropdown-menu dropdown-menu-dark dropdown-menu-lg-end' aria-labelledby='dropdownMenuButton1'>
                                    <li>   
                                        <a href='screener.php' class='dropdown-item'>Screener</a>
                                    </li>
                                    <li>   
                                        <a href='logout.php' class='dropdown-item' >Logout</a>
                                    </li>
                                </ul>
                            </li>";  
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row container">
        <div class="col-9">
            <h1>Valore totale wallet:</h1>
            <div class="text-center"><h2 id="valore"></h2></div>
        </div>
        <div class="col-3" >
            <div class="chart-canvas">
                <!-- tag canvas usato dalla libreria chart.js per la creazione di grafici -->
                <canvas id="graficotot" ></canvas>
    
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-8 align-content-left table-responsive">
            <h1>zona azioni</h1>
            <?php
                //controllo del login 
                 if(!isset($_SESSION['utente'])){
                    echo "Per usare il wallet devi effettuare il <a href='login.html' class='link-light' >Login</a>";  
                }else{
                    //estrazione dei dati presenti nel database 
                    $dbconn=pg_connect("host=localhost dbname=Progetto port=5432 user=postgres password=progetto");
                    $email=$_SESSION['email'];
                    $query='select * from portafogli where email=$1';
                    $result=pg_query_params($dbconn,$query,array($email));
                    echo '<table name="tabella" class="table text-white" rules="rows">';
                        echo '<tr>';
                        echo '<th>Nome</th>';
                        echo '<th>ISIN</th>';
                        echo '<th>Quantità</th>';
                        echo '<th>Valore</th>';
                        echo '</tr>';
                        $posizioni=array();
                        $valori=array();
                        $paesi=array();
                        $settori=array();
                        $dizpaesi=array();
                        $dizsettori=array();
                        $count=1;         
                        //inserimento dei dati estratti nel database in una tabella
                        while($line=pg_fetch_array($result,null, PGSQL_ASSOC)){
                           
                            $azione=$line['azione'];
                            $query2='select nome,prezzo,paese,settore from azioni where isin=$1';
                            $result2=pg_query_params($dbconn,$query2,array($azione));
                            $line2=pg_fetch_array($result2,null,PGSQL_ASSOC);
                            echo '<tr>';
                            echo '<td>' . $line2['nome'] . '</td>';
                            echo "<td >" . $azione .  '</td>';
                            echo '<td>' . $line['quantita'] . '</td>';
                            echo '<td>' . $line2['prezzo']*$line['quantita'] . '</td>';
                            echo '</tr>';
                            $posizioni[$count]=$azione;
                            $valori[$count]=$line2['prezzo']*$line['quantita'];
                            //salvo in degli array i valori che mi serviranno per la creazione dei grafici
                            if(in_array($line2['paese'],$paesi)){
                                $temp1=$dizpaesi[$line2['paese']];
                                $dizpaesi[$line2['paese']]=$temp1+$valori[$count];
                            }else{
                                $paesi[$count]=$line2['paese'];
                                $dizpaesi[$line2['paese']]=$valori[$count];
                            } 
                            if(in_array($line2['settore'],$settori)){
                                $temp2=$dizsettori[$line2['settore']];
                                $dizsettori[$line2['settore']]=$temp2+$valori[$count];
                            }else{
                                $settori[$count]=$line2['settore'];
                                $dizsettori[$line2['settore']]=$valori[$count];
                            }
                            $count+=1;
                        }
                    echo '</table>';
                    $valsettori=array_values($dizsettori);
                    $valpaesi=array_values($dizpaesi);        
                    $posizione=json_encode($posizioni);
                    $valore=json_encode($valori);
                    $paese=json_encode($paesi);
                    $settore=json_encode($settori);
                    $valsettori=json_encode($valsettori);
                    $valpaesi=json_encode($valpaesi);    
                    $b=true;       
                    
                    echo "</div>
                    <div class='col-3 walletgraphs'>
                        <div class='chart-canvas'>
                            <canvas id='graficoallocazione'></canvas>
                        </div>
                        <div class='chart-canvas'>
                            <canvas id='graficosettori'></canvas>
                        </div>
                    </div>
                </div>";
                //invio di dati ad una funzione javascript necessari per la creazione dei grafici
                echo "<script>stampaValori($posizione,$valore,$paese,$settore,$valpaesi,$valsettori)</script>";
                echo "<script>caricaGrafico($posizione,$valore,$paese,$settore,$valpaesi,$valsettori)</script>";
                }
    ?>
     
</body>
</html>