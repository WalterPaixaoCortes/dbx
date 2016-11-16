import time
import pprint
import sys
import importlib

from Modulos.AgendamentoDAO import AgendamentoDAO
from Modulos.Log import Log
from Modulos.ThreadComponente import ThreadComponenteColeta
from Modulos.ThreadComponente import ThreadComponenteRefinamento
import threading


class Controlador:
    timer = None
    databaseComponentes = None
    databaseADM = None
    configuracao = None
    log = None

    def __init__(self, d, dADM):
        self.databaseComponentes = d
        self.databaseADM = dADM

    def verificar(self):
        while True:
            time.sleep(2)
            print("Executando ...")
            agendamentos = AgendamentoDAO.listar_pendentes(self.databaseADM)
            for a in agendamentos:
                a.atualizar()
                threads = []
                i = 0
                try:
                    for c in a.componentes:
                        print("Iniciando componente "+c['nome'])

                        if c['tipo'] == "col":
                            t = ThreadComponenteColeta(i, self.databaseComponentes, c, a)
                        if c['tipo'] == "ref":
                            t = ThreadComponenteRefinamento(i, self.databaseADM, c, a)
                        t.start()
                        i = i + 1

                        if a.paralelismo == True:
                            threads.append(t)
                        else:
                            t.join()

                    for t in threads:
                        t.join()
                except:
                    Log.adicionar("Erro ao gerenciar threads, AgendamentoID: " + str(a.id))
                    for t in threads:
                        t.join()
                    return

        return