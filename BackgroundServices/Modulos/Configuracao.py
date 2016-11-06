from Modulos.Arquivo import Arquivo

class Configuracao():

    def carregar(self, dir):
        c = Arquivo()
        return c.abrir_xml(dir)['configuracao']