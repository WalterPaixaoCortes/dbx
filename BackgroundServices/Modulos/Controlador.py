import time
import pprint
import sys
import importlib


from Modulos.AgendamentoDAO import AgendamentoDAO
from Modulos.Log import Log

sys.path.append(sys.path[0]+"/../Componentes/Coleta")


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
                    try:
                        if c['tipo'] == "col":
                            self.carregar_coleta(c['nome'])
                        if c['tipo'] == "ref":
                            self.carregar_refinamento(c['nome'])

                        pprint.pprint(c['id'])
                    except ImportError:
                        Log.adicionar("Erro ao tentar importar componente. ComponenteID:" + str(c['id']) + " ComponenteNome:" +c['nome'] + " AgendamentoID: " + str(a.id))
                    except:
                        Log.adicionar("Erro ao tentar executar o componente. ComponenteID:"+str(c['id'])+" ComponenteNome:"+c['nome']+" AgendamentoID: "+str(a.id))
        return

    def carregar_coleta(self, nome):
        Main = importlib.import_module(nome + ".Main")
        m = Main.Main(self.databaseComponentes, "tabela")
        m.extract()
        m.parse()
        m.save()
        return

    def carregar_refinamento(self, nome):
        #carrega componente de refinamento
        return

