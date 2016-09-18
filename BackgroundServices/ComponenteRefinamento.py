from .Componente import *

class ComponenteRefinamento(Componente):
    tabela = None

    def __init__(self, d, t):
        Componente.__init__(self, d)
        self.tabela = t
        return