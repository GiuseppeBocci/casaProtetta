#!/usr/bin/python3
import os
import sys
import mysql.connector

idutentevpn = sys.argv[1]
con = mysql.connector.connect(host = "localhost",
				user = "admincasa",
				passwd = "*****",
				database = "casap")
cursore = con.cursor()
query = "SELECT utentevpn FROM utentivpn WHERE idutentevpn = "+str(idutentevpn)
cursore.execute(query)
result = cursore.fetchall()
utentevpn = result[0][0]

command = "echo ***** | su - pi -s /bin/bash -c 'cp /home/pi/ovpns/"+utentevpn+".ovpn /var/www/html/casap/certs/'"
p = os.system(command)

command = "echo ***** | su - pi -s /bin/bash -c 'zip /var/www/html/casap/certs/"+utentevpn+".zip /var/www/html/casap/certs/"+utentevpn+".ovpn'"
p = os.system(command)

print("<script type='text/javascript'>window.location.href = 'certs/"+utentevpn+".zip';</script>")
cursore.close()
con.close()
