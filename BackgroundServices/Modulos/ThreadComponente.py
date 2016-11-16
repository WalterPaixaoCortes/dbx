import time
import pprint
import sys
import importlib

from Modulos.AgendamentoDAO import AgendamentoDAO
from Modulos.Log import Log
import threading

class ThreadComponente(threading.Thread):
    def __init__(self, threadID, database, componente, agendamento):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.componente = componente
        self.agendamento = agendamento
        self.database = database
        return



class ThreadComponenteColeta(ThreadComponente):

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


class ThreadComponenteRefinamento(ThreadComponente):

    def run(self):
        try:
            Log.adicionar("Executando ComponenteID:" + str(self.componente['id']) + " ComponenteNome:" + self.componente['nome'] + " AgendamentoID: " + str(self.agendamento.id))
            self.carregar_refinamento(self.componente['nome'], self.componente['id'])
        except ImportError:
            Log.adicionar("Erro ao tentar importar componente. ComponenteID:" + str(self.componente['id']) + " ComponenteNome:" +self.componente['nome'] + " AgendamentoID: " + str(self.agendamento.id))
        except:
            Log.adicionar("Erro ao tentar executar o componente. ComponenteID:" + str(self.componente['id']) + " ComponenteNome:" + self.componente['nome'] + " AgendamentoID: " + str(self.agendamento.id))

    def carregar_refinamento(self, nome, id):
        Main = importlib.import_module("Componentes.Refinamento." + nome + ".Main")
        m = Main.Main(self.database, id)
        m.extract()
        m.save()
        return
