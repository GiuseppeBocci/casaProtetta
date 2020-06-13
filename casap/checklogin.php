<?php include "database.php";

/*$result = mysqli_query($con, $query);
  while($row = mysqli_fetch_assoc($result)){
  }*/

  $azione = $_GET['a'];

  if($azione == 'r'){
    session_destroy();
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $motivazione = $_POST["motivazione"];
    $nome = mysqli_real_escape_string($con, $nome);
    $cognome = mysqli_real_escape_string($con, $cognome);
    $password = mysqli_real_escape_string($con, $password);
   // $password = md5($password);
    $email = mysqli_real_escape_string($con, $email);
    $motivazione = mysqli_real_escape_string($con, $motivazione);

    $query =  sprintf("SELECT * FROM utenti WHERE email = '%s'", $email);
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    if($row["idutente"] == ""){
      $query =  sprintf(
        "INSERT INTO utenti (nome, cognome, email, password, motivazione, attivo)
          VALUES ('%s', '%s', '%s', '%s', '%s', false);",
              $nome, $cognome, $email, $password, $motivazione);

      mysqli_query($con, $query);

      $query = "SELECT email FROM utenti WHERE idutente = 1;";
      $result = mysqli_query($con, $query);
      $row= mysqli_fetch_assoc($result);

      $to = $row["email"];
      $subject = 'RICHIESTA DI ISCRIZIONE';


      $query =  sprintf("SELECT idutente FROM utenti WHERE email = '%s' AND password = '%s';", $email, $password);
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_assoc($result);

      $message = "<html><head></head>".
                  "<body> <h1>Hai una nuova richiesta di iscrizione:</h1>".
                  "<p>nome: $nome<br />".
                  "cognome: $cognome<br />".
                  "email: $email<br />".
                  "motivazione: $motivazione<br />".
                  "Attiva il profilo <a href='****attivautente.php?id=".
                  $row["idutente"]."'>qui</a></body></html>";

      $mail_headers  = 'MIME-Version: 1.0' . "\r\n";
      $mail_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $mail_headers .= "From: *****\r\n";
      $mail_headers .= "X-Mailer: PHP/" . phpversion();
     
      $r = mail($to, $subject, $message, $mail_headers);
      if(!$r){
        echo '<script type="text/javascript">
  			alert("Notifica inviata all\'amministratore")
  			window.location= "login.html"
  			</script>';
      }
      else{
        echo '<script type="text/javascript">
        alert("Notifica inviata ed email inviate all\'amministratore")
        window.location= "login.html"
        </script>';
      }
    }
    else{
      echo '<script type="text/javascript">
      alert("Email già usata!")
      window.location= "login.html"
      </script>';
    }
    //mysqli_close($con);
  }
  else if($azione == 'l'){
    session_start();

    $password = $_POST["password"];
    $email = $_POST["email"];
    $password = mysqli_real_escape_string($con, $password);
    $email = mysqli_real_escape_string($con, $email);

    $query =  sprintf("SELECT * FROM utenti WHERE email = '%s' AND password = '%s';", $email, $password);
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    if($row["idutente"] == "" or !$row["attivo"]){
      //mysqli_close($con);
      session_destroy();
      header("location: login.html");
    }
    else{
      //$_SESSION["con"] = $con;
      $_SESSION["idutente"] = $row["idutente"];
      $_SESSION["nome"] = $row["nome"];
      $_SESSION["cognome"] = $row["cognome"];
      $_SESSION["email"] = $row["email"];
      $_SESSION["utentevpn"] = $row["utentevpn"];
      header("location: home.php");
    }
  }
  else{
    session_destroy();
    header("location: login.html");
  }
  mysqli_close($con);

?>
