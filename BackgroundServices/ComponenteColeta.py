from .Componente import *

class ComponenteColeta(Componente):

    def __init__(self, d, t):
        Componente.__init__(self, d)
        return

    #pdbp

    #busca e coleta as informações das bases de dados externas
    def extract(self):
        return

    #normalização dos dados
    def parse(self):
        return

    #salvar o resultado no banco de dados interno
    def save(self):
        return