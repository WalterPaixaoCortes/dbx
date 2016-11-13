import time
import pprint
import sys
import importlib

from Modulos.AgendamentoDAO import AgendamentoDAO
from Modulos.Log import Log
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
                            t.start()
                        if c['tipo'] == "ref":
                            ThreadComponenteRefinamento(i, self.databaseADM, c, a)
                            t.start()
                        i = i + 1

                        if a.paralelismo == True:
                            threads.append(t)
                        else:
                            t.join()
                    for t in threads:
                        print("Aguardando thread " + t.componente['nome'])
                        t.join()
                except:
                    print("Erro de thread")
                    Log.adicionar("Erro ao gerenciar threads, AgendamentoID: " + str(a.id))
                    for t in threads:
                        t.join()
                    return

        return


class ThreadComponenteColeta(threading.Thread):
    def __init__(self, threadID, database, componente, agendamento):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.componente = componente
        self.agendamento = agendamento
        self.database = database
        return

    def run(self):
        try:
            Log.adicionar("Executando ComponenteID:" + str(self.componente['id']) + " ComponenteNome:" + self.componente['nome'] + " AgendamentoID: " + str(self.agendamento.id))
            self.carregar_coleta(self.componente['nome'], self.componente['nometabela'], self.componente['id'],self.componente['proteina'])
        except ImportError:
            Log.adicionar("Erro ao tentar importar componente. ComponenteID:" + str(self.componente['id']) + " ComponenteNome:" +self.componente['nome'] + " AgendamentoID: " + str(self.agendamento.id))
        except:
            Log.adicionar("Erro ao tentar executar o componente. ComponenteID:" + str(self.componente['id']) + " ComponenteNome:" + self.componente['nome'] + " AgendamentoID: " + str(self.agendamento.id))

    def carregar_coleta(self, nome, tabela, id, proteina):
        Main = importlib.import_module("Componentes.Coleta." + nome + ".Main")
        m = Main.Main(self.database, tabela, id, proteina)
        m.extract()
        m.parse()
        m.save()
        return


class ThreadComponenteRefinamento(threading.Thread):
    def __init__(self, threadID, database, componente, agendamento):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.componente = componente
        self.agendamento = agendamento
        self.database = database
        return

    def run(self):
        try:
            Log.adicionar(
                "Executando ComponenteID:" + str(self.componente['id']) + " ComponenteNome:" + self.componente[
                    'nome'] + " AgendamentoID: " + str(self.agendamento.id))
            self.carregar_refinamento(self.componente['nome'])
        except ImportError:
            Log.adicionar(
                "Erro ao tentar importar componente. ComponenteID:" + str(self.componente['id']) + " ComponenteNome:" +
                self.componente['nome'] + " AgendamentoID: " + str(self.agendamento.id))
        except:
            Log.adicionar("Erro ao tentar executar o componente. ComponenteID:" + str(
                self.componente['id']) + " ComponenteNome:" + self.componente['nome'] + " AgendamentoID: " + str(
                self.agendamento.id))

    def carregar_refinamento(self, nome):
        # carrega componente de refinamento
        return
