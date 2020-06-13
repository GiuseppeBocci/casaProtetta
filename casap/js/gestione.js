function mostra(elemento){
  elemento.style.display='block';
}

function chiudi(elemento){
  elemento.style.display='none';
}

function mostraModal(inner){
  inner = '<div id="modal-content">'+
    '<span onclick="chiudi(modal);" class="close">&times;</span>'+inner;
  inner += '</div>';
  modal.innerHTML = inner;
  mostra(modal);
}

function modificaMaxCert(idutente){
  var modalC = '<center><form action="gestione.php" action="get">'+
      '<h4>Numero massimo:</h4>'+
      '<input type="number" min="1" id="ncert" name="ncert" value="2"><br><br>'+
      '<input type="hidden" name="a" value="mc">'+
      '<input type="hidden" name="id" value="'+idutente+'">'+
      '<input type="submit" value="Conferma">'+
    '</form></center>';
  mostraModal(modalC);
}

function aggiungiVideocamera(){
  var modalC = '<center><form action="gestione.php" action="get">'+
      '<h4>Compleata i campi</h4>'+
      '<input type="text" name="ip" placeholder="192.168.1.xxx" required><br><br>'+
      '<input type="text" name="nome" placeholder="nome" required><br><br>'+
      '<input type="hidden" name="a" value="av">'+
      '<input type="submit" value="Conferma">'+
    '</form></center>';
  mostraModal(modalC);
}


function aggiungiCertificato(){
  var modalC = '<center><form action="creacertificato.php" action="get">'+
      '<h4>Compleata i campi</h4>'+
      '<input type="text" name="n" placeholder="nome" required><br><br>'+
      '<input type="submit" value="Conferma">'+
    '</form></center>';
  mostraModal(modalC);
}

