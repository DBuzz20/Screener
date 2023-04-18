# Screener
Progetto per il corso di "Linguaggi e Tecnologie per il Web"

Corso di laurea in "Ingegneria Informatica e Automatica" presso Sapienza Università di Roma.

Front-end realizzato con HTML, CSS e JavaScript ; Back-end realizzato con PHP.

## Descrizione
Screener è una Web App che permette ai suoi utenti di cercare, tra i titoli azionari quotati al Nasdaq, quelli di loro interesse, filtrandoli secondo svariati parametri di analisi fondamentale che caratterizzano le aziende che hanno emesso gli stessi.
Questi titoli sono aggiornati periodicamente, tramite una funzione ajax che invoca una chiamata API la quale, interagendo con un'applicazione esterna, recupera tutti i valori dei parametri d'interesse.

Una volta individuati, questi possono essere aggiunti al proprio portafoglio, il quale presenta anche 3 grafici a torta descriventi in percentuale: titoli posseduti, allocazione geografica e allocazione settoriale. A questi si affianca la lista dei titoli posseduti con la quantità che l'utente ha aggiunto per gli stessi, il valore complessivo di ogni singola posizione, ed infine il valore totale del portafoglio creato.

L'applicazione presenta poi anche un sistema di login e registrazione, necessari per poter usufruire al servizio del portafoglio, ed un occhio in particolare alla responsiveness del sito, così che esso possa essere navigato senza problemi anche da dispositivi più piccoli.
