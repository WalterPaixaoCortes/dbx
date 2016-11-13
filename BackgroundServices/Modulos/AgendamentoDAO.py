

class AgendamentoDAO():

    @staticmethod
    def listar_pendentes(databaseADM):
        agendamentos = databaseADM.find("agendamentos", ["ativo = true","((ultimaExecucao + INTERVAL intervalo DAY) <= NOW() OR (ultimaExecucao is NULL And (inicio + INTERVAL intervalo DAY) <= NOW()))"],["id", "nome", "paralelismo"])
        pendentes = []
        for a in agendamentos:
            p = AgendamentoDAO()
            p.database = databaseADM
            p.id = a['id']
            p.nome = a['nome']
            p.paralelismo = a['paralelismo']
            p.componentes = databaseADM.query("SELECT idComponente as id, nome, nometabela, ordem, tipo, proteina FROM agendamentos_componentes inner join componentescoletarefinamento on componentescoletarefinamento.id = idComponente Where idAgendamento = "+str(a['id'])+" order by idAgendamento, ordem")
            pendentes.append(p)
        return pendentes

    def atualizar(self):
        self.database.execute("Update agendamentos Set ultimaExecucao = NOW() Where id = "+str(self.id))

