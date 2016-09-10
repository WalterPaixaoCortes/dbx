import array

class Database:
    conexao = []

    def __init__(self, usuario, senha, host, base):
        self.conexao['user'] = usuario
        self.conexao['password'] = senha
        self.conexao['host'] = host
        self.conexao['database'] = base
        return

    def insert(self, tabela, values):
        return

    def find(self, tabela, where):
        return

    def query(self, consulta):
        return

    def execute(self, comando):
        return

