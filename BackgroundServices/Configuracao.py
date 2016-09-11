from BackgroundServices.Arquivo import Arquivo
class Configuracao():

    def carregar(self):
        c = Arquivo()
        return c.abrir_xml("Config.xml")['configuracao']