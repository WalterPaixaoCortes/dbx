
class Configuracao():

    database = None

    def __init__(self, d):
        self.database = d
        return

    def carregar(self):
        print("configuracao")
        return