class Log:
    Database = None

    def __init__(self, database):
        self.Database = database
        return

    def adicionar(self, msg):
        return