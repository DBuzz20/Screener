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
    session_start();
    if(!isset($_POST["login"])){
        header("location: index.php");
    }else{
        $dbconn=pg_connect("host=localhost dbname=Progetto port=5432 user=postgres password=progetto");
        $email=$_POST["email"];
            $query='select * from utenti where email=$1';
            $result=pg_query_params($dbconn,$query,array($email));
            if(!($line=pg_fetch_array($result,null, PGSQL_ASSOC))) {
                header("location: ./login.html");
            }
            else{
                $password=md5($_POST["password"]);
                $query2='SELECT * FROM utenti where email=$1 and pass=$2';
                $result=pg_query_params($dbconn,$query2,array($email,$password)) or die("errore");
                if(!($line=pg_fetch_array($result,null, PGSQL_ASSOC ))){
                    die("C'e' stato un errore");
                }else{
                    $_SESSION['utente']=$line['nome'];
                    $_SESSION['email']=$line['email'];
                    header("location: ./screener.php");
                }
            }
    }
    ?>
</body>
</html>