<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="funzioni.js"></script>
    <link rel="stylesheet" href="stile.css" type="text/css"/> 
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <title>Stock Screener</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
   
</head>
<body class="homeScreener">
    <?php       
    //inizio sessione
        session_start();
    ?>
    <!-- creazione della navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0">
        <div class="container-fluid">
            <div>
                <a class="navbar-brand " href="index.php" ><img src="./img/logo.PNG" class="logo"> Home Page</img></a>   
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcontent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarcontent">
                <form class="d-flex" method="POST" action="screener.php">
                    <input class="form-control me-2" type="search" name="ricerca" placeholder="Ricerca per ISIN" aria-label="Search">
                    <button class="btn btn-outline-warning btn-lg" type="submit">Search</button>
                </form>
                <ul class="navbar-nav ms-md-auto " >
                    <?php
                        if(!isset($_SESSION['utente'])){
                            echo"<li class='nav-item m-2'><a href='login.html' class='link-light'>Login</a></li>";  
                        }else{ 
                            echo"<li class='nav-item dropdown'> 
                                    <a class='nav-link dropdown-toggle' type='button' id='dropDownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>";
                                         echo $_SESSION['utente'];
                                    echo "</a>
                                <ul class='dropdown-menu dropdown-menu-dark  dropdown-menu-lg-end' aria-labelledby='dropdownMenuButton'>
                                    <li>   
                                        <a href='wallet.php' class='dropdown-item'>Wallet</a>
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

    <!-- creazione delle select per filtrare i dati              -->
    <form action="screener.php" method="POST" name="filter">
        <div class="text-center">
            <div class="row m-2">
                <div class="col">
                    <testoScreener>Market Cap:</testoScreener>
                    <testoScreener class="hovertext" data-hover="La MarketCap indica la dimensione dell'azienda nel mercato. 
                    Questo valore è dato dal prezzo di una singola azione moltiplicato il numero totale di azioni emesse 
                    sul mercato."><B><I><U>?</U></I></B></testoScreener>
                    <select name="marketcap" class="form-select">
                        <option value=""></option>
                        <option value="<2000000000">Small(&lt;2 Miliardi)</option>
                        <option value=">=2000000000 and marketcap<10000000000">Medium(tra 2 e 10 Miliardi)</option>
                        <option value=">=10000000000 and marketcap<200000000000">Large(tra 10 e 200 Miliardi)</option>
                        <option value=">=200000000000">Mega(&gt;200 Miliardi)</option>
                    </select>
                </div>
                <div class="col">
                    <testoScreener>Settore:</testoScreener>
                    <select  name="settore" class="form-select">
                        <option></option>
                        <option value="='Communication Services'">Telecomunicazioni</option>
                        <option value="='Consumer Cyclical'">Consumer discretionary</option>
                        <option value="='Consumer Defensive'">Beni di prima necessità</option>
                        <option value="='Financial Services'">Finanziario</option>
                        <option value="='Healthcare'">Salute</option>
                        <option value="='Industrials'">Industriale</option> 
                        <option value="='Technology'">Tecnologico</option>
                        <option value="='Utilities'">Utilities</option>
                    </select>
                </div>
                <div class="col">
                    <testoScreener>Paese:</testoScreener>
                    <select name="paese" class="form-select">
                        <option></option>
                        <option value="='Australia'">Australia</option>
                        <option value="='Canada'">Canada</option>
                        <option value="='China'">Cina</option>
                        <option value="='Netherlands'">Paesi Bassi</option>
                        <option value="='United Kingdom'">Regno Unito</option>
                        <option value="='United States'">Stati Uniti</option>
                        <option value="='Uruguay'">Uruguay</option>
                    </select>
                </div>
                    <div class="col">
                    <testoScreener>Prezzo:</testoScreener>
                    <select name="prezzo" class="form-select">
                        <option></option>
                        <option value=">=1 AND prezzo<10">tra 1 e 10$</option>
                        <option value=">=10 AND prezzo<50">tra 10 e 50$</option>
                        <option value=">=50 AND prezzo<200">tra 50 e 200$</option>
                        <option value=">=200">&gt;200$</option>
                    </select>
                </div>
                    <div class="col">
                    <testoScreener>Volume:</testoScreener>
                    <select name="volume" class="form-select">
                        <option></option>
                        <option value="<500000">&lt;500k</option>
                        <option value=">=500000 AND volume<5000000">tra 500k e 5 Milioni</option>
                        <option value=">=5000000">&gt;5 Milioni</option>
                    </select>
                </div>
                <div class="col">
                    <testoScreener>P/E:       </testoScreener>
                    <testoScreener class="hovertext" data-hover="Price to Earnings indica quanto gli investitori sono disposti a pagare
                    per ottenere 1$ di utili.E' un indicatore che da un idea su quanto sia cara un azienda e sulle aspettative che il
                    mercato ha per essa."><B><I><U>?</U></I></B></testoScreener>
                    <select name="pe" class="form-select">
                        <option></option>
                        <option value="<15">Basso(&lt;15)</option>
                        <option value=">=15 AND pe<40">Medio(tra 15 e 40)</option>
                        <option value=">=40">Alto(&gt; 40)</option>
                    </select>
                </div> 
                <div class="col">
                    <testoScreener>P/S:       </testoScreener>
                    <testoScreener class="hovertext" data-hover="Price To Sales è calcolato dividendo la capitalizzazione di mercato
                    per i ricavi degli ultimi 12 mesi.Il rapporto descrive quanto bisogna pagare per comprare un'azione dell'azienda 
                    rispetto a quanto quell'azione è in grado di generare ricavi per la società"><B><I><U>?</U></I></B></testoScreener>
                    <select name="ps" class="form-select">
                        <option></option>
                        <option value="<1">&lt;1</option>
                        <option value=">=1 AND ps<10">tra 1 e 10</option>
                        <option value=">=10">&gt;10</option>
                    </select>
                </div>
            </div>
            <div class="row m-2">
                <div class="col">
                    <testoScreener>P/B:       </testoScreener>
                    <testoScreener class="hovertext" data-hover="Price To Book è il rapporto tra il prezzo di mercato di un'azione 
                    e il valore del capitale proprio della società per azione. Se inferiore a 1, indica che l'azienda
                    sta venendo valutata dal mercato meno di quanto non valga già oggi."><B><I><U>?</U></I></B></testoScreener>
                    <select name="pb" class="form-select">
                        <option></option>
                        <option value="<1">&lt;1</option>
                        <option value=">=1 AND pb<5">tra 1 e 5</option>
                        <option value=">=5">&gt;5</option>
                    </select>
                </div>

                <div class="col">
                    <testoScreener>Dividend Yield:</testoScreener>
                    <testoScreener class="hovertext" data-hover="E' il rapporto tra l'ultimo dividendo pagato dalla società ed il costo
                    attuale di una sua azione.Se questo valore è 0,significa che l'azienda non rilascia dividendi."><B><I><U>?</U></I></B></testoScreener>
                    <select name="divyield" class="form-select">
                        <option></option>
                        <option value="=0">Nessun dividendo</option>
                        <option value=">0">Positivo(&gt;0%)</option>
                        <option value=">0.05">Alto(&gt;5%)</option>
                        <option value=">0.10">Molto Alto(&gt;10%)</option>
                    </select>
                </div>

                <div class="col">
                    <testoScreener>ROE:       </testoScreener>
                    <testoScreener class="hovertext" data-hover="Return On Equity misura la redditività del capitale proprio di un azienda,
                    cioè del capitale messo a disposizione da proprietari e investitori e non di quello di terzi.">
                    <B><I><U>?</U></I></B></testoScreener>
                    <select name="roe"  class="form-select">
                        <option></option>
                        <option value="<-0.15">Molto Negativo(&lt;-15%)</option>
                        <option value="<0">Negativo(&lt;0%)</option>
                        <option value=">=0">Positivo(&gt;0%)</option>
                        <option value=">=0.15" >Molto Positivo(&gt;15%)</option>
                    </select>
                </div>
                <div class="col">
                    <testoScreener>ROA:       </testoScreener>
                    <testoScreener class="hovertext" data-hover="Return On Assets viene utilizzato per verificare l’abilità dell’impresa nel
                    realizzare un flusso di reddito dallo svolgimento della propria attività.Permette dicapire se l’azienda è capace di rendere 
                    redditivi i propri asset, ovvero le proprie risorse."><B><I><U>?</U></I></B></testoScreener>
                    <select name="roa" class="form-select">
                        <option></option>
                        <option value="<-0.15">Molto Negativo(&lt;-15%)</option>
                        <option value="<0">Negativo(&lt;0%)</option>
                        <option value=">=0">Positivo(&gt;0%)</option>
                        <option value=">=0.15">Molto Positivo(&gt;15%)</option>
                    </select>
                </div>
                <div class="col">
                    <testoScreener>Debt/equity:</testoScreener>
                    <testoScreener class="hovertext" data-hover="Indica quanto l'azienda finanzia le sue attività
                    attraverso il debito."><B><I><U>?</U></I></B></testoScreener>
                    <select name="debteq" class="form-select">
                        <option></option>
                        <option value=">=1">&gt;1</option>
                        <option  value=">=0.5">&gt;0.5</option>
                        <option  value="<0.5">&lt;0.5</option>
                        <option  value="<0.2">&lt;0.2</option>
                    </select>
                </div>
                <div class="col">
                    <testoScreener>Profit Margin:</testoScreener>
                    <testoScreener class="hovertext" data-hover="Il margine di profitto mostra qual è la percentuale delle entrate
                    complessive dell'azienda rispetto ai costi e alle spese aziendali.Indica quindi quanta percentuale del ricavo
                    totale lordo diventerà Utile per l'azienda."><B><I><U>?</U></I></B></testoScreener>
                    <select name="opmargin" class="form-select">
                        <option></option>
                        <option  value="<=-0.20">Molto Negativo(&lt;-20%)</option>
                        <option  value="<0">Negativo(&lt;0%)</option>
                        <option  value=">=0">Positivo(&gt;0%)</option>
                        <option  value=">=0.20">Molto Positivo(&gt;20%)</option>
                    </select>
                </div>
                <div class="col">
                    <testoScreener>EBITDA:    </testoScreener>
                    <testoScreener class="hovertext" data-hover="Earnings Before Interest, Taxes, Depreciation and Amortisation.
                    Evidenzia il reddito di un'azienda basato solo sulla sua gestione operativa,senza considerare interessi,
                    imposte,deprezzamento e ammortamenti."><B><I><U>?</U></I></B></testoScreener>
                    <select name="ebitda" class="form-select">
                        <option></option>
                        <option value="<-0.20">Molto Negativo(&lt;-20%)</option>
                        <option value="<0">Negativo(&lt;0%)</option>
                        <option value=">=0">Positivo(&gt;0%)</option>
                        <option value=">=20">Molto Positivo(&gt;20%)</option>
                    </select>   
                </div> 
            </div>
        </div>
        <div class="text-center"><input type="submit" id="bottonescreener" class="btn btn-outline-warning btn-lg"> </div>


    </form>
    <br>
    
    <?php
        // creazione di una finestra modale tramite click di un bottone per aggiungere un azione al proprio portafoglio
        // (comprare solo se loggati)
        if(isset($_SESSION['utente'])){
            echo "
            <div style='text-align:center'>
                <button type='button' class='btn btn-warning btn-lg btn-block' data-bs-toggle='modal' data-bs-target='#myModal'> Aggiungi al wallet </button>
                <div class='modal' id='myModal'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>Aggiungi al wallet</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                            </div>
                            <div class='modal-body'>
                                <form action='aggiungiWallet.php' method='POST' name='aggiungiWallet'>
                                    <div class='mb-3'>
                                        <label class='form-label required'>ISIN:</label>";
                                        $dbconn=pg_connect("host=localhost dbname=Progetto port=5432 user=postgres password=progetto");
                                        echo "<select name='isin' class='form-select'>";
                                        echo "<option selected>Seleziona l'ISIN</option>";
                                        $query='select isin from azioni order by isin';
                                        $result=pg_query_params($dbconn,$query,array()) or die("errore");
                                        while( $tupla=pg_fetch_array($result,null,PGSQL_ASSOC)){
                                            echo "<option value='".$tupla['isin']."'>".$tupla['isin']."</option>";
                                        }
                                        echo"</select>
                                        <div class='mb-3'>
                                            <label class='form-label required'>Quantità:</label>
                                            <input name='quantita' type='number' min='1' class='form-control'>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='submit' name='registration' class='btn btn-warning'>Submit</button>
                                            <button type='reset' class='btn btn-danger'>Cancel</button>
                                        </div>       
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
        }else{
            echo "<div class='text-center text-white'> effettua il <a class='btn btn-warning btn-sm link-ligth' href=login.html>Login</a> per aggiungere azioni al tuo wallet</div>";
        }
    ?>
    <div id="id"></div> 
   <div class="text-white" id="prova"></div>
    <div class=" ps-lg-4 text-start p-2   text-white table-responsive-xxl">
        <table class="table text-white" id="myTable">
            <thead>
              <tr>  <!--header tabella con funzione onClick per ordinare la lista-->
                <th class='clickable' scope="col" onClick="ordinaLista(0);">No.</th>
                <th class='clickable' scope="col" onClick="ordinaLista(1);">Nome</th>
                <th class='clickable' scope="col" onClick="ordinaLista(2);">Isin</th>
                <th class='clickable' scope="col" onClick="ordinaLista(3);">Settore</th>
                <th class='clickable' scope="col" onClick="ordinaLista(4);">Market Cap</th>
                <th class='clickable' scope="col" onClick="ordinaLista(5);">Paese</th>
                <th class='clickable' scope="col" onClick="ordinaLista(6);">Prezzo</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $dbconn=pg_connect("host=localhost dbname=Progetto port=5432 user=postgres password=progetto");
                $count=0;
                $query='select nome,isin,settore,marketcap,paese,prezzo from azioni';
                // creazione query con condizioni selezionate nella form filter e ricerca
                foreach($_POST as $index => $line){
                    if($index=="ricerca"){
                        $query.=" where isin LIKE upper('".$line."%')";
                    }else{
                    if($line!=""){
                        if($count==0){
                            $query.=" where ".$index.$line;
                            $count=1;
                        }
                        else{
                            $query.=" AND ".$index.$line;
                        }
                    }
                }
                }   
                $query.=" order by isin";
                $result=pg_query_params($dbconn,$query,array());
                if ($result==false){
                    echo "<tr>Non è stata trovata alcuna azione che rispetta i parametri selezionati</tr>";
                }else{
                $count=1;
                $isin=[];
                //riempimento della tabella con i dati estratti dal database
                while( $tupla=pg_fetch_array($result,null,PGSQL_ASSOC)){
                    echo "<tr><td>$count</td>";
                    echo "<td>".$tupla['nome']."</td>";
                    echo "<td>".$tupla['isin']."</td>";
                    echo "<td>".$tupla['settore']."</td>";
                    echo "<td>".$tupla['marketcap']."</td>";
                    echo "<td>".$tupla['paese']."</td>";
                    echo "<td>".$tupla['prezzo']."</td></tr>";
                    $count+=1;
                    $isin[$count]=$tupla['isin'];
                }
            }     
            $isin1=json_encode($isin);
            echo"<script>ajax($isin1)</script>";
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>