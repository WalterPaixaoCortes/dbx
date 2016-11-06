import pprint
class Log:
    database = None

    @staticmethod
    def adicionar(msg):
        colunas = {"mensagem":msg, "origem":"BS"}
        Log.database.insert("log", colunas)
        return