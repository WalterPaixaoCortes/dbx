from array import*
import pprint

import sys

from Modulos.Controlador import Controlador
from Modulos.Database import Database
from Modulos.Configuracao import Configuracao
from Modulos.Log import Log


class Main():

    def loop(self):
        while True:
            c = Configuracao()
            config = c.carregar("Config.xml")
            databaseComponente = Database(config['db']['usuario'],config['db']['senha'],config['db']['host'],config['db']['database'])
            databaseADM = Database(config['dbADM']['usuario'], config['dbADM']['senha'], config['dbADM']['host'],config['dbADM']['database'])
            Log.database = databaseADM

            controlador = Controlador(databaseComponente,databaseADM)
            controlador.verificar()
        return

m = Main()
m.loop()