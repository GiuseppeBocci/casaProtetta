<?php
  include "database.php";
  session_start();

  if(array_key_exists("u", $_GET)){
    $idutentevpn = $_GET["u"];
    if (!ctype_digit($idutentevpn)){
      $idutentevpn = -1;
    }

    $query = "SELECT * FROM utentivpn WHERE idutente = ".$_SESSION["idutente"]." AND idutentevpn = ".$idutentevpn.";";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    if($row["idutentevpn"] ==  $idutentevpn){
      //richiamo script py
      mysqli_close($con);
      $command = escapeshellcmd("python3 py/scert.py $idutentevpn");
      $tmp = shell_exec($command);
      echo $tmp;
      //echo "<script type='text/javascript'>window.location.href = 'home.php';</script>";
    }
    else{
      $idutentevpn = -1;
    }

    if($idutentevpn == -1){
      echo "<h2 align='center'>Azione non consentita!</h2>";
      session_destroy();
    }
  }
  else{
    echo "<h2 align='center'>Azione non consentita!</h2>";
    session_destroy();
  }

  mysqli_close($con);
