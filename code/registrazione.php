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
        if(!isset($_POST["registration"])){
            header("location: ./index.php");
        }else{
            $dbconn=pg_connect("host=localhost dbname=Progetto port=5432 user=postgres password=progetto");
            $email=$_POST["email"];
            $query='select * from utenti where email=$1';
            $result=pg_query_params($dbconn,$query,array($email));
            if($tupla=pg_fetch_array($result,null,PGSQL_ASSOC)){
                header("location: ./register.html");
            }
            else{
                $email=$_POST["email"];
                $nome=$_POST["nome"];
                $cognome=$_POST["cognome"];
                $password=md5($_POST["password"]);
                $tipo=$_POST["tipo"];
                $query2='INSERT into utenti values($1,$2,$3,$4,$5)';
                $result=pg_query_params($dbconn,$query2,array($email,$nome,$cognome,$password,$tipo)) or die("errore");
                if($result){
                    header("location: ./screener.php");
                }else{
                    die("C'e' stato un errore");
                }
            }
        }
    ?>
</body>
</html>