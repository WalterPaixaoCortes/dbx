from .Componente import *

class ComponenteRefinamento(Componente):

    def __init__(self, d, id):
        Componente.__init__(self, d)
        self.dir = "./Resultados"
        self.idComponente = id
        return

    def extract(self):
        # print("extract")
        return

    def save(self):
        return