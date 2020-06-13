<?php
echo '<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/gestione.css">
    <script src="js/gestione.js"></script>
    <title>Gestore</title>
  </head>
  <body>';
  session_start();
  if($_SESSION["idutente"] == 1){
    echo '<h2>Gestore hub</h2>';
    echo '<a title="vai a scheda profilo" href="home.php"><img src="img/user_y.png" alt="profilo" style="width: 20px;"/></a>';
    echo '<center>
      <div id="scheda">
        <div class="dropdown">
          <span class="campo">GESTIONE UTENTI VPN</span>
          <div class="dropdown-content">
          <p><a href="?a=eu">Elenco utenti</a></p>
          <p><a href="?a=ec">Elenco certificati</a></p>
          <p><a href="?a=cu">Utenti da confermare</a></p>
          </div>
        </div>
        <br /> <br />
        <div class="dropdown">
          <span class="campo">GESTIONE VIDOCAMERE</span>
          <div class="dropdown-content">
            <p><a href="?a=ev">Elenco videocamere</a></p>
            <p onclick="aggiungiVideocamera();">Aggiungi videocamera</p>
          </div>
        </div>
        <br /> <br />
        <div class="dropdown">
          <span class="campo">GESTIONE ALEXA</span>
          <div class="dropdown-content">
            <p>Presto disponibile...</p>
          </div>
        </div>
      </div>';
    if(array_key_exists("a", $_GET)){
      include "database.php";

      $rv = False; //rimuovi videocamera
      if($_GET["a"] == "rv")
        $rv = True;
      $modifica = False;
      if($_GET["a"] == "mc")
        $modifica = True;
      if($_GET["a"] == "eu" || $modifica){
        if($modifica){ //modifica maxcert
          $idutentevpn = $_GET["id"];
          $ncert = $_GET["ncert"];
          if (ctype_digit($idutentevpn) && ctype_digit($ncert)){
            $query = "UPDATE utenti SET maxCert = $ncert WHERE idutente = $idutentevpn;";
            mysqli_query($con, $query);
          }
        }
        $query = "SELECT * FROM utenti WHERE attivo = 1";// AND idutente != 1;";
        $result = mysqli_query($con, $query);
        echo "<br /><br /><table>";
        echo "<tr><th>Idutente</th><th>Nome</th><th>Cognome</th><th>Email</th><th>Max Certificati</th><th>Modifica MaxCert</th></tr>";
        while($row = mysqli_fetch_assoc($result)){
         echo "<tr><td>".$row["idutente"]."</td><td>".$row["nome"]."</td><td>".$row["cognome"]."</td><td>".$row["email"].
         "</td><td>".$row["maxcert"]."</td><td onclick='modificaMaxCert(".$row["idutente"].");'><img src='img/edit.png' alt='edit'/></td></tr>";
        }
        echo "</table>";
      }
      else if($_GET["a"] == "ev" || $rv){
        if($rv){ //rimuovi videocamera
          $idcam = $_GET["id"];
          if(ctype_digit($idcam)){
            $query = "DELETE FROM cams WHERE idcam = $idcam;";
            mysqli_query($con, $query);
          }
        }
        $query = "SELECT * FROM cams";
        $result = mysqli_query($con, $query);
        echo "<br /><br /><table>";
        echo "<tr><th>Idcam</th><th>Ip</th><th>Nome</th><th>Rimuovi</th></tr>";
        while($row = mysqli_fetch_assoc($result)){
         echo "<tr><td>".$row["idcam"]."</td><td><a href='http:\\\\".$row["ip"]."'>".$row["ip"]."<a/></td><td>".$row["nome"].
         "</td><td><a href='?a=rv&id=".$row["idcam"]."'><img style='width:15px;' src='img/x.png' alt='rimuovi'/></a></td></tr>";
        }
      }
      else if($_GET["a"] == "av"){ //aggiungi videocamera
        $ip = $_GET["ip"];
        $nome = $_GET["nome"];
        $ip = mysqli_real_escape_string($con, $ip);
        $nome = mysqli_real_escape_string($con, $nome);
        $query =  sprintf(
          "INSERT INTO cams (ip, nome)
            VALUES ('%s', '%s');", $ip, $nome);
        mysqli_query($con, $query);
      }
      else if($_GET["a"] == "cu"){ //utenti da confermare
        $query = "SELECT * FROM utenti WHERE attivo = 0";
        $result = mysqli_query($con, $query);
        echo "<br /><br /><table>";
        echo "<tr><th>Idutente</th><th>Nome</th><th>Cognome</th><th>Email</th><th>Motivazione</th><th>Attiva</th></tr>";
        while($row = mysqli_fetch_assoc($result)){
         echo "<tr><td>".$row["idutente"]."</td><td>".$row["nome"]."</td><td>".$row["cognome"]."</td><td>".$row["email"].
         "</td><td>".$row["motivazione"]."</td><td><a href='attivautente.php?id=".$row["idutente"].
         "'><img src='img/correct.png' alt='conferma'/></a></td></tr>";
        }
        echo "</table>";
      }
      /*else if($_GET["a"] == "ec"){
        $query = "SELECT * FROM utentivpn";
        $result = mysqli_query($con, $query);
        echo "<br /><br /><table>";
        echo "<tr><th>Idutente</th><th>Nome</th><th>Cognome</th><th>Email</th><th>Motivazione</th><th>Attiva</th></tr>";
        while($row = mysqli_fetch_assoc($result)){
         echo "<tr><td>".$row["idutente"]."</td><td>".$row["nome"]."</td><td>".$row["cognome"]."</td><td>".$row["email"].
         "</td><td>".$row["motivazione"]."</td><td><a href='attivautente.php?id=".$row["idutente"].
         "'><img src='img/correct.png' alt='conferma'/></a></td></tr>";
        }
        echo "</table>";

      mysqli_close($con);
   }
    echo "</center>";
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
    session_destroy();
  }
  echo "</body></html>";

