<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //inizio sessione
        session_start();
        if(!isset($_POST["registration"])){
            //reindirizamento se si accede in modo impropio 
            header("location: ./index.php");
        }else{
            $dbconn=pg_connect("host=localhost dbname=Progetto port=5432 user=postgres password=progetto");
            $email=$_SESSION['email'];
            $isin=$_POST['isin'];
            $quantita=$_POST['quantita'];
            //prima query per controllare se in database è già presente un azione nel wallet dell'utente loggato
            $query='select quantita from portafogli where email=$1 and azione=$2';
            $result=pg_query_params($dbconn,$query,array($email,$isin));
            if($tupla=pg_fetch_array($result,null,PGSQL_ASSOC)){
                //aggiornamento della quantita in database se è già presente
                $quantita+=$tupla['quantita'];
                $query2='update portafogli SET quantita=$1';
                $result2=pg_query_params($dbconn,$query2,array($quantita));
            }
            else{
                //inserimento in database se non è presente
                $query2='insert into portafogli values($1,$2,$3)';
                $result2=pg_query_params($dbconn,$query2,array($email,$isin,$quantita));
            }
            header("location: ./screener.php");
        }
    ?>
</body>
</html>