import urllib.request as urllib
import xml.etree.ElementTree as xml
import pprint
import xlsxwriter
import time

from Modulos.ComponenteRefinamento import ComponenteRefinamento

class Main(ComponenteRefinamento):

    def extract(self):
        print("Extract")
        dados = self.database.query("SELECT proteina, proteinas.nome, nometabela FROM componentescoletarefinamento inner join proteinas on proteinas.id = componentescoletarefinamento.proteina WHERE ativo = 1 and tipo like 'col' and nometabela is not null")
        self.valores = {}
        for dado in dados:
            self.valores[dado['nome']] = 0;
        for dado in dados:
            count = self.database.query("Select count(*) as soma From "+dado['nometabela'])
            self.valores[dado['nome']] = self.valores[dado['nome']]+(count[0]['soma']);

        return

    def save(self):
        print("Save")
        workbook = xlsxwriter.Workbook(self.dir+"/Graficos"+str(time.strftime("%d-%m-%Y_%R"))+".xlsx")
        worksheet = workbook.add_worksheet()
        worksheet.write_row("A1", ["Proteína", "Número de Registros"], workbook.add_format({"italic":True,"fg_color":"#68b468", "align":"center"}))
        worksheet.write_column("A2", self.valores.keys())
        worksheet.write_column("B2", self.valores.values())
        grafico = workbook.add_chart({"type":"column"})
        qnt = str(len(self.valores)+1)
        grafico.add_series({"name":"Nº de Estruturas", "categories":"=Sheet1!A2:A"+qnt, "values":"=Sheet1!B2:B"+qnt})
        worksheet.insert_chart("D1", grafico)
        worksheet.set_column(0,1,30)
        workbook.close()
        return
