import array

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
        return

    #Find(tabela, where[])
    def find(self, tabela, where):
        return

    #Query(tabela, consulta)
    def query(self, consulta):
        return

    #Execute(comando)
    def execute(self, comando):
        return

