from array import*
from BackgroundServices.Controlador import Controlador
from BackgroundServices.Database import Database
from BackgroundServices.Configuracao import Configuracao

class Main():


    def loop(self):
        while True:
            c = Configuracao()
            config = c.carregar()
            database = Database(config['db']['usuario'],config['db']['senha'],config['db']['host'],config['db']['database'])
            controlador = Controlador(database)
            controlador.verificar()
        return

m = Main()
m.loop()