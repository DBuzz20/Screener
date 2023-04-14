//funzione chiamata dalla pagina wallet.php per l'inserimento del valore totale del wallet
function stampaValori(posizioni,valori,paesi,settori,valpaesi,valsettori){
    var tot=0;
    for(i=1;i<=Object.keys(valori).length;i++)
        tot+=valori[i];
    document.getElementById("valore").innerHTML=tot.toFixed(2)+"$";
    
}
   
//array contenente dei colori per il background dei grafici
var colors= [
    "#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "#c6e1e8", "#1e7145" ,"#0d5ac1" ,
    "#f205e6" ,"#1c0365" ,"#14a9ad" ,"#4ca2f9" ,"#a4e43f" ,"#d298e2" ,"#6119d0",
    "#d2737d" ,"#c0a43c" ,"#f2510e" ,"#651be6" ,"#79806e" ,"#61da5e" ,"#cd2f00" ,
    "#9348af" ,"#01ac53" ,"#c5a4fb" ,"#996635","#b11573" ,"#4bb473" ,"#75d89e" ,
    "#2f3f94" ,"#2f7b99" ,"#da967d" ,"#34891f" ,"#b0d87b" ,"#ca4751" ,"#7e50a8" ,
    "#c4d647" ,"#e0eeb8" ,"#11dec1" ,"#289812" ,"#566ca0" ,"#ffdbe1" ,"#2f1179" ,
    "#935b6d" ,"#916988" ,"#513d98" ,"#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
    "#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
    "#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
    "#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
    "#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
    "#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
    "#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
    "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
    "#79352c", "#521250", "#c79ed2", "#d6dd92"];


//funzione che crea i grafici nella pagina wallet.php dove sono presenti i tag canvas, a cui si aggancia chart.js
function caricaGrafico(posizione,valori,paesi,settori,valpaesi,valsettori){
    var  gTot=document.getElementById('graficotot').getContext('2d');
    //creazione primo grafico
    new Chart(gTot,{
        type:'pie', //prova anche 'polarArea' come type
        data: {
            labels:Object.values(posizione),
            datasets:[{
                data:Object.values(valori),
                backgroundColor:colors,
                borderWidth:1,
                borderColor:'#0000',
                hoverBorderWidth:2,
                hoverBorderColor:'#FFFFFF'
            }]
        },
        options:{
            plugins:{
                title:{display:true,text:'Valore Wallet',fontSize:'24',fontFamily:"'Roboto',sans-serif",color:"#FFFFFF"},
                legend:{display:true,position:'right',align:'center',labels:{
                    color:"#FFFFFF"
                }
            }
        }
    }
    });

    //creazione secondo grafico
    let gAlloc=document.getElementById("graficoallocazione").getContext('2d');
    new Chart(gAlloc,{
        type:'pie', //prova anche 'polarArea' come type
        data: {
            labels:Object.values(paesi),
            datasets:[{
                data:Object.values(valpaesi),
                backgroundColor:colors,
                borderWidth:1,
                borderColor:'#0000',
                hoverBorderWidth:2,
                hoverBorderColor:'#FFFFFF'
            }]
        },
        options:{
            plugins:{ 
                title:{display:true,text:'Allocazione geografica',fontSize:'24',fontFamily:"'Roboto',sans-serif",color:"#FFFFFF"},
                legend:{display:true,position:'top',align:'center',labels:{
                    color:"#FFFFFF"
                    }
                }
            }
        }
    });

    //creazione terzo grafico
    let gSett=document.getElementById("graficosettori").getContext('2d');
    new Chart(gSett,{
        type:'pie', //prova anche 'polarArea' come type
        data: {
            labels:Object.values(settori),
            datasets:[{
                data:Object.values(valsettori),
                backgroundColor:colors,
                borderWidth:1,
                borderColor:'#0000',
                hoverBorderWidth:2,
                hoverBorderColor:'#FFFFFF'
            }]
        },
        options:{
            plugins:{
                title:{display:true,text:'Allocazione settoriale',fontSize:'24',fontFamily:"'Roboto',sans-serif",color:"#FFFFFF"},
                legend:{display:true,position:'top',align:'center',labels:{
                    color:"#FFFFFF"
                    }
                }
            }
        }
    });

    const tooltips = document.querySelectorAll('.tt')
        tooltips.forEach(t => {
        new bootstrap.Tooltip(t)
    })
}

//funzione per l'ordinamento della tabella nella pagina screener.php al click di uno dei parametri nell'header
function ordinaLista(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true; 
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        var b=isNaN(rows[1].getElementsByTagName("TD")[n].innerHTML);
        if(b){
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {            
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                     }
                }
            }
        }else{
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {            
                    if (Number(x.innerHTML) > Number(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (Number(x.innerHTML) < Number(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
              dir = "desc";
              switching = true;
            }
        }
    }
}
count1=1;


//funzione che aggiorna i dati della tabella in tempo reale.
//in particolare,vengono aggiornati i valori di 3 azioni nel db ogni 10 secondi.
function ajax(isin){  
    let interval=setInterval(aggiorna,10000);
    function aggiorna(){
        isin1={isin:isin[count1],isin1:isin[count1+1],isin2:isin[count1+2]};
        $.ajax({
        type: "POST",
        url: "inserisci.php",
        data: isin1
        })
        .done(function( ) {
        });
        if(count1==103){
            count1=0;
            clearInterval(interval);
        }else{
            count1+=3;
        }
    }
}
