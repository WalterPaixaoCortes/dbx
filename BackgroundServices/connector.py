import mysql.connector

config = {
    'user' : 'dbx',
    'password':'dbx',
    'host' : '127.0.0.1',
    'database': 'db'
}

cnx = mysql.connector.connect(**config)

cursor = cnx.cursor()

cursor.close()
cnx.close()

