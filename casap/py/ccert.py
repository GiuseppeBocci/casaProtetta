#!/usr/bin/python3
import os
import sys
import mysql.connector

idutente = sys.argv[1]
nome = sys.argv[2]

print("Step 1")

con = mysql.connector.connect(host = "localhost",
				user = "admincasa",
				passwd = "******",
				database = "casap")
print("Step 2")
cursore = con.cursor()
query = "SELECT password FROM utenti WHERE idutente = "+str(idutente)
print("Step 3")
cursore.execute(query)
result = cursore.fetchall()
password = result[0][0]
print("Step 4")
query = "SELECT COUNT(*) FROM utentivpn WHERE idutente = "+str(idutente)
cursore.execute(query)
result = cursore.fetchall()
ncert = result[0][0] + 1
print("Step 5")
query = "SELECT maxcert FROM utenti WHERE idutente = "+str(idutente)
cursore.execute(query)
result = cursore.fetchall()
maxcert = result[0][0]
print("Step 6")
if maxcert >= ncert:
  utentevpn = "utente"+idutente+"_"+str(ncert)
  print("Step 7")
  query = "INSERT INTO utentivpn (utentevpn, idutente, nome) VALUES ('%s', %s, '%s');" % (utentevpn, idutente, nome)
  #print(query)
  cursore.execute(query)
  print("Step 8")
  command = "echo **** | su - pi -s /bin/bash -c 'pivpn add -n %s -p %s -d 1080'"
  p = os.system(command % (utentevpn, password))
  print("Step 9")
  if p != 0:
    query = "DELETE FROM utentivpn WHERE utentevpn = %s;" % utentevpn
    cursore.execute(query)
    print("<h1>Azione fallita</h1>")
  else:
    print("<h1>Azione eseguita correttamente!</h1>")

else:
  print("<h1>Numero di certificati massimi raggiunto. Azione fallita!</h1>")

cursore.close()
con.commit()
con.close()

