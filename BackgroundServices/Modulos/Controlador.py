import time
import pprint
import sys
import importlib


from Modulos.AgendamentoDAO import AgendamentoDAO
from Modulos.Log import Log

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
                for c in a.componentes:
                    pprint.pprint(c)
                    # try:
                    if c['tipo'] == "col":
                        Log.adicionar("Executando ComponenteID:" + str(c['id']) + " ComponenteNome:" + c['nome'] + " AgendamentoID: " + str(a.id))
                        self.carregar_coleta(c['nome'], c['nometabela'], c['id'], c['proteina'])
                    # if c['tipo'] == "ref":
                    #     self.carregar_refinamento(c['nome'])
                    # except ImportError:
                    #     Log.adicionar("Erro ao tentar importar componente. ComponenteID:" + str(c['id']) + " ComponenteNome:" +c['nome'] + " AgendamentoID: " + str(a.id))
                    # except:
                    #     Log.adicionar("Erro ao tentar executar o componente. ComponenteID:"+str(c['id'])+" ComponenteNome:"+c['nome']+" AgendamentoID: "+str(a.id))
        return

    def carregar_coleta(self, nome, tabela, id, proteina):
        Main = importlib.import_module("Componentes.Coleta."+nome + ".Main")
        m = Main.Main(self.databaseComponentes, tabela, id, proteina)
        m.extract()
        m.parse()
        m.save()
        return

    def carregar_refinamento(self, nome):
        #carrega componente de refinamento
        return

