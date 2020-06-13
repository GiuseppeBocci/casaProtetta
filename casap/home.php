<?php
echo '<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/home.css">
    <script src="js/gestione.js"></script>
    <title>Home</title>
  </head>
  <body>';
  session_start();
  if($_SESSION["email"] != ""){
      echo '<h2>Scheda profilo</h2>';
      if($_SESSION["idutente"] == 1){
        echo '<a title="vai a impostazioni" href="gestione.php"><img src="img/gear.png" alt="impostazioni" style="width: 20px;"/></a>';
      }
      echo '<center>
        <div id="scheda">
          <img src="img/user.png" alt="utente" style="width: 40px;"/>
          <br /> <br />
          <span class="campo">Nome: <i>'.$_SESSION["nome"].'</i> </span>
          <br /> <br />
          <span class="campo">Cognome: <i>'.$_SESSION["cognome"].'</i></span>
          <br /> <br />
          <span class="campo">Email: <i>'.$_SESSION["email"].'</i></span>
          <br /> <br />
          <div id="utentivpn">
            <span class="campo">UtentiVpn:</span><br />';
            include "database.php";
            $query = "SELECT idutentevpn, utentevpn, nome FROM utentivpn WHERE idutente = ".$_SESSION["idutente"].";";
            $result = mysqli_query($con, $query);
            while($row = mysqli_fetch_assoc($result)){
              echo "<br /><a class='utentivpn' href='scaricacertificato.php?u=".$row['idutentevpn'].
              "' title='scarica certificato per ".$row['nome']."'>".$row['utentevpn']."</a>";
            }
        echo '<br /><br /><img title="aggiungi utente vpn" onclick="aggiungiCertificato(modal)"  id="aggiungi" alt="+ utente vpn" style="width: 16px;" src="img/add.png"/>
        </div>
        <div>
        <br />
        <a id="logout" href="checklogin.php" title="Esci">Logout</a>
      </center>';
      echo '<div id="modal"></div>';
      echo "<script>
         var modal = document.getElementById('modal');
         window.onclick = function(event) {
         if (event.target == modal) {
            chiudi(modal);
          }
        }
        </script>";
       }
    else{
      echo "<h2>Accesso alla pagina negato!</h2>";
    }
  echo "</body>
</html>";
mysqli_close($con);
