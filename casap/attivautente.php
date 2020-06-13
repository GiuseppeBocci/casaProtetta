<?php
  include "database.php";
  session_start();

  if(array_key_exists("id", $_GET)){
    $idutente = $_GET["id"];
    if(ctype_digit($idutente) && $_SESSION["idutente"] == 1){
      $query = "UPDATE utenti SET attivo = 1 WHERE idutente = $idutente;";
      $result = mysqli_query($con, $query);
      header('Location: https://lamiacasaprotetta.ddns.net/casap/gestione.php');
    }
    else{
      echo "<h2 align='center'>Azione non consentita!</h2>";
      session_destroy();
    }
  }
  else{
    echo "<h2 align='center'>Azione non consentita!</h2>";
    session_destroy();
  }

  mysqli_close($con);
