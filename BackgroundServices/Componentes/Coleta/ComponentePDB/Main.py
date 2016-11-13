import urllib.request as urllib
import xml.etree.ElementTree as xml
import pprint

from Modulos.ComponenteColeta import ComponenteColeta

class Main(ComponenteColeta):

    def extract(self):
        self.estruturas = []
        print("Extract PDB")

        temp = self.database.find(self.tabela, colunas=['estrutura'])
        atuais = []
        for t in temp:
            atuais.append(t['estrutura'])

        temp = self.buscar_estruturas()
        estruturas = []
        for e in temp:
            e = e[0:4]
            if (e in atuais):
                continue
            estruturas.append(e[0:4])

        self.carregar_estruturas(estruturas)
        return

    def parse(self):
        # print("Parse")
        return

    def save(self):
        for estrutura in self.estruturas:
            self.database.insert(self.tabela, estrutura)
            print("Save PDB")
        print("Save PDB")
        return

    def queryPDB(self, url, query_xml = None):
        if query_xml == None:
            req = urllib.Request(url)
        else:
            req = urllib.Request(url, data=query_xml.encode())
        f = urllib.urlopen(req)
        result = f.read()
        return result.decode()

    def buscar_estruturas(self):
        url = "http://www.rcsb.org/pdb/rest/search"
        query = """<?xml version="1.0" encoding="UTF-8"?>
        <orgPdbQuery>
        <queryType>org.pdb.query.simple.SequenceClusterQuery</queryType>
        <description>Sequence Cluster Name Search : Name=InhA</description>
        <sequenceClusterName>InhA</sequenceClusterName>
        <comparator>equals</comparator>
        </orgPdbQuery>"""

        r = self.queryPDB(url, query)
        return list(filter(None,str.split(r,'\n')))



    def carregar_estruturas(self, estruturas):
        for estrutura in estruturas:
            self.carregar_estrutura(estrutura)


    def carregar_estrutura(self, eID):
        url = "http://www.rcsb.org/pdb/rest/customReport.xml?pdbids="+str(eID)+"&customReportColumns=structureTitle,pdbDoi,classification,depositionDate,releaseDate,structureAuthor,source,expressionHost,experimentalTechnique,resolution,title,authorAssignedEntityName,chainLength,geneName,ligandName"
        req = urllib.urlopen(url).read().decode()
        req = xml.fromstring(req)
        e = req[0]

        # --- Campos ---
        estrutura = {"estrutura": e.find("dimEntity.structureId").text,
        "ligantes": "",
        "descricao": e.find("dimStructure.structureTitle").text,
        "link": "http://www.rcsb.org/pdb/explore/explore.do?structureId="+e.find("dimEntity.structureId").text,
        "doi": e.find("dimStructure.pdbDoi").text,
        "classificacao": e.find("dimStructure.classification").text,
        "depositado": e.find("dimStructure.depositionDate").text,
        "lancado": e.find("dimStructure.releaseDate").text,
        "organismo": e.find("dimEntity.source").text,
        "expressao": str(e.find("dimEntity.expressionHost").text),
        "metodo": e.find("dimStructure.experimentalTechnique").text,
        "resolucao": e.find("dimStructure.resolution").text,
        "artigoorigem": e.find("dimStructure.title").text,
        "artigoautores": e.find("dimStructure.structureAuthor").text,
        }

        url = "http://www.rcsb.org/pdb/rest/customReport.xml?pdbids="+str(eID)+"&customReportColumns=compound,chainLength,geneName"
        req = urllib.urlopen(url).read()
        req = xml.fromstring(req)
        cadeias = {}

        for e in req:
            if not (e.find("dimEntity.compound").text) in cadeias.keys():
                cadeias[e.find("dimEntity.compound").text] = []
            cadeias[e.find("dimEntity.compound").text].append(e.find("dimEntity.chainId").text)

        for k,c in cadeias.items():
            cadeias[k] = ",".join(c)

        macromoleculas = []
        e = []
        for m in req:
            if m.find("dimEntity.compound").text in e:
                continue
            e.append(m.find("dimEntity.compound").text)

            try:
                macromoleculas.append("""[\" """ +m.find("dimEntity.compound").text + """ \",
                                               \" """ + cadeias[m.find("dimEntity.compound").text] + """ \",
                                               \" """ + m.find("dimEntity.chainLength").text + """ \",
                                               \" """ + estrutura['organismo'] + """ \",
                                               \"Gene Name(s): """ + str(m.find("dimEntity.geneName").text) + """ \"]
                """)
            except:
                None

        if macromoleculas:
            estrutura['macromolecula'] = ("""
                {
                    "nome":\"Macromoléculas\",
                    \"colunas\":[\"Molécula\",\"Cadeias\",\"Tamanho\",\"Organismo\",\"Detalhes\"],
                    \"valores\":[""" + ",".join(macromoleculas) + """]}
            """)

        url = "http://www.rcsb.org/pdb/rest/ligandInfo?structureId=" + str(eID)
        req = urllib.urlopen(url).read()
        req = xml.fromstring(req)[0]

        ligantes = []
        strLigantes = []

        for ligante in req:
            strLigantes.append(estrutura['ligantes']+ligante.find("chemicalName").text)
            ligantes.append("""[\" """ + ligante.get("chemicalID") + """ \",
                                                \" """ + ligante.find("chemicalName").text + """ \",
                                                \" """ + ligante.find("formula").text + """ \",
                                                \" """ + ligante.find("InChIKey").text + """ \"]
                """)

        estrutura['ligantes'] = ",".join(strLigantes)

        if ligantes:
            estrutura['tabelaligantes'] = ("""
                {
                    "nome":\"Ligantes\",
                    \"colunas\":[\"ID\",\"Nome\",\"Fórmula\",\"InChIKey\"],
                    \"valores\":[""" + ", ".join(ligantes) + """]}
            """)
        print("Extract PDB")

        self.estruturas.append(estrutura)



