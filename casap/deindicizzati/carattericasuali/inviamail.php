<?php
      include "../../database.php";

      $query = "SELECT email FROM utenti WHERE idutente = 1;";
      $result = mysqli_query($con, $query);
      $row= mysqli_fetch_assoc($result);

      $to = $row["email"];
      $subject = 'MOVIMENTO SOSPETTO!';

      $message = "<html><head></head>".
                  "<body> <h1>E' stato registrato un movimento sospetta a casa tua!</h1>".
                  "<p>ore:".date("d/m/Y h:i:sa")."<br />".
                  "<b>Si consiglia di visionare le telecamere di sicurezza</b></p></body></html>";

      $mail_headers  = 'MIME-Version: 1.0' . "\r\n";
      $mail_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $mail_headers .= "From: <xxxx>\r\n";
      $mail_headers .= "X-Mailer: PHP/" . phpversion();
     
      $r = mail($to, $subject, $message, $mail_headers);
