<?php
  include "database.php";
  session_start();

  $nome = $_GET["n"];
  //TO DO safe $nome
  if($_SESSION["idutente"] != "")
  {
    $query = "SELECT * FROM utenti WHERE idutente = ".$_SESSION["idutente"].";";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    if($row["attivo"] == True){
      //richiamo script py
      mysqli_close($con);
      echo "<h1>python3 py/ccert.py ".$_SESSION["idutente"]." ".$nome."</h1>"; 
      $command = escapeshellcmd("python3 py/ccert.py ".$_SESSION["idutente"]." ".$nome."");
      $tmp = shell_exec($command);
      echo $tmp;
      echo "<h1>Script eseguito</h1>";
    }
    
  }
  else{
    session_destroy();
    echo "<h1>Sessione non iniziata</h1>";
  }
   
  mysqli_close($con);
