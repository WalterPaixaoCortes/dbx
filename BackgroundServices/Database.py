import array
import mysql.connector

class Database:
    conexao = {}

    def __init__(self, usuario, senha, host, base):
        self.conexao['user'] = usuario
        self.conexao['password'] = senha
        self.conexao['host'] = host
        self.conexao['database'] = base
        return

    # Insert(tabela, values[])
    def insert(self, tabela, values):
        cnx = mysql.connector.connect(**self.conexao)
        cursor = cnx.cursor()
        # Adicionar Comando Insert
        cursor.close()
        cnx.close()
        return

    #Find(tabela, where[])
    def find(self, tabela, where):
        cnx = mysql.connector.connect(**self.conexao)
        cursor = cnx.cursor()
        # Adicionar Query
        cursor.close()
        cnx.close()
        return

    #Query(tabela, consulta)
    def query(self, consulta):
        cnx = mysql.connector.connect(**self.conexao)
        cursor = cnx.cursor()
        # Adicionar Query
        cursor.close()
        cnx.close()
        return

    #Execute(comando)
    def execute(self, comando):
        cnx = mysql.connector.connect(**self.conexao)
        cursor = cnx.cursor()
        # Adicionar Execute
        cursor.close()
        cnx.close()
        return

