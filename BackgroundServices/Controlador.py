import time

class Controlador:
    timer = None
    database = None
    configuracao = None
    log = None

    def __init__(self, d):
        self.database = d

    def verificar(self):
        while True:
            time.sleep(2)
            print("ok")
        return

    def carregar(self):
        return

    def carregar_coleta(self):
        #carrega componente de coleta
        return

    def carregar_refinamento(self):
        #carrega componente de refinamento
        return

