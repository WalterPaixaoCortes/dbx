class Log:
    database = None

    def __init__(self, database):
        self.database = database
        return

    def adicionar(self, msg):
        return