import array
import mysql.connector
import pprint

class Database:

    def __init__(self, usuario, senha, host, base):
        self.conexao = {}
        self.conexao['user'] = usuario
        self.conexao['password'] = senha
        self.conexao['host'] = host
        self.conexao['database'] = base
        return

    # Insert(tabela, values[])
    def insert(self, tabela, values):
        cnx = mysql.connector.connect(**self.conexao)
        cursor = cnx.cursor()
        for k, v in values.items():
            if not (isinstance(v, int)):
                values[k] = "'" + v.replace("'","\\'") + "'"
            else:
                values[k] = str(v)

        cursor.execute("Insert Into " + tabela + "(" + (','.join(values.keys())) + ") Values(" + (",".join(values.values())) + ")")
        cnx.commit()
        cursor.close()
        cnx.close()
        return

    #Find(tabela, where[], colunas[], ordem, dicionario)
    def find(self, tabela, where = [], colunas = [], ordem = "", dict=True):
        cnx = mysql.connector.connect(**self.conexao)
        cursor = cnx.cursor(dictionary=dict)
        c = "*"
        if colunas:
            c = ", ".join(colunas)
        w = ""
        if where:
            w = " Where "+" AND ".join(where)
        cursor.execute("Select "+c+" From "+tabela+" "+w+" "+ordem)
        r = cursor.fetchall()
        cursor.close()
        cnx.close()
        return r

    def query(self, comando):
        cnx = mysql.connector.connect(**self.conexao)
        cursor = cnx.cursor(dictionary=True)
        cursor.execute(comando)
        r = cursor.fetchall()
        cursor.close()
        cnx.close()
        return r


    def execute(self, comando):
        cnx = mysql.connector.connect(**self.conexao)
        cursor = cnx.cursor(dictionary=True)
        cursor.execute(comando)
        cnx.commit()
        cursor.close()
        cnx.close()
        return