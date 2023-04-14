<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        
    </head>

    <body>
        <?php
            $dbconn=pg_connect("host=localhost dbname=Progetto port=5432 user=postgres password=progetto");
            $url=array();
            $count=0;
            //creazione di un array con url per la richiesta API
            foreach($_POST as $nome){
                $url[$count]="https://yh-finance.p.rapidapi.com/stock/v2/get-summary?symbol=".$nome ;
                $url[$count] = str_replace(array("\n","\r"), "",$url[$count]);
                $count+=1;
            }
            
            //loop che richiede i dati e aggiorna il database
            foreach($url as $url1){
                $curl = curl_init();
                //richiesta API
                curl_setopt_array($curl, [
                    CURLOPT_URL =>$url1,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: yh-finance.p.rapidapi.com",
                        "X-RapidAPI-Key: " #inserire qui la propria api_key di RapidAPI
                    ]]);
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                    
                if ($err!="") {
                    echo "cURL Error #:" . $err;
                    break 1;
                } else {
                    // raccolta risultati della richiesta
                    $result=json_decode($response);
                    $isin= $result->{'symbol'};
                    $marketcap=$result->{'summaryDetail'}->{'marketCap'}->{'raw'};
                    $prezzo=$result->{'financialData'}->{'currentPrice'}->{'raw'};
                    $volume=$result->{'summaryDetail'}->{'volume'}->{'raw'};
                    $pe=$result->{'defaultKeyStatistics'}->{'forwardPE'}->{'raw'};
                    $ps=$result->{'summaryDetail'}->{'priceToSalesTrailing12Months'}->{'raw'};
                    $pb=$result->{'defaultKeyStatistics'}->{'priceToBook'}->{'raw'};
                    $divyield=$result->{'summaryDetail'}->{'trailingAnnualDividendYield'}->{'raw'};
                    $roe=$result->{'financialData'}->{'returnOnEquity'}->{'raw'};
                    $roa=$result->{'financialData'}->{'returnOnAssets'}->{'raw'};            
                    $debteq=$result->{'financialData'}->{'debtToEquity'}->{'raw'};
                    $opmargin=$result->{'financialData'}->{'operatingMargins'}->{'raw'};
                    $ebitda=$result->{'financialData'}->{'ebitdaMargins'}->{'raw'};
                    //aggiornamento dati in database
                    $query1='UPDATE azioni SET  marketcap=$1,prezzo=$2,volume=$3,pe=$4,ps=$5,pb=$6,divyield=$7,roe=$8,roa=$9,debteq=$10,opmargin=$11,ebitda=$12 where isin=$13';
                    $result1=pg_query_params($dbconn,$query1,array($marketcap,$prezzo,$volume,$pe,$ps,$pb,$divyield,$roe,$roa,$debteq,$opmargin,$ebitda,$isin)) or die("errore");
                    echo "fatto";
                }
            }
        ?>
    </body>
</html>

