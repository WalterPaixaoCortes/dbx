import urllib.request as urllib
import xml.etree.ElementTree as xml
import time
import pprint

from Modulos.ComponenteColeta import ComponenteColeta

class Main(ComponenteColeta):

    def extract(self):
        print("Extract")

        self.artigos = []

        url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=pubmed&term=InhA[title]&retmax=1000"
        req = xml.fromstring(urllib.urlopen(url).read().decode())
        count = int(req.find("Count").text);
        retmax = int(req.find("RetMax").text)
        iteracoes = int(count/retmax)+1 if (count%retmax) > 0 else int(count/retmax)

        i = 0
        start = 0
        ids = []
        self.novosAutores = []
        autoresAtuais = []
        artigosAtuais = self.database.find("artigos", where=[" componente = "+str(self.idComponente)], colunas=['idExterno'])

        temp = self.database.find("autores", colunas=["nome"])
        for t in temp:
            autoresAtuais.append(t['nome'])

        while True:
            for id in req.find("IdList").iter("Id"):
                if {"idExterno":''+str(id.text)} in artigosAtuais:
                    continue
                ids.append(id.text)
            i = i + 1
            if(i >= iteracoes):
                break
            start = retmax*i
            url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=pubmed&term=InhA[TI]&retmax=100&retstart="+str(start)
            req = xml.fromstring(urllib.urlopen(url).read().decode())

        for id in ids:
            url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pubmed&id=" +str(id)+"&retmode=xml&rettype=abstract&tool=DBX&email=gustavo.frainer@acad.pucrs.br"
            req = xml.fromstring(urllib.urlopen(url).read().decode())
            artigo = {"autores" : [], "dados":{"componente":self.idComponente, "proteina":self.idProteina, "idExterno":str(id)}}
            for au in req.iter("Author"):
                aut = ((str(
                    (au.find("LastName").text if au.find("LastName") != None else "")
                )+", "+str(
                    (au.find("ForeName").text if au.find("ForeName") != None else "")
                )).strip())
                if aut != ",":
                    if not aut in autoresAtuais:
                        self.novosAutores.append(aut)
                    artigo['autores'].append(aut)

            artigo['dados']['titulo'] = list(req.iter("ArticleTitle"))[0].text
            abstract = list(req.iter("AbstractText"))
            if abstract:
                artigo['dados']['abstract'] = abstract[0].text
            data = list(req.iter("ArticleDate"))
            if data:
                artigo['dados']['data'] = time.strftime("%Y-%m-%d",time.strptime(data[0].find("Day").text+"/"+data[0].find("Month").text+"/"+data[0].find("Year").text, "%d/%b/%Y"))
            artigo['dados']['link'] = "https://www.ncbi.nlm.nih.gov/pubmed/?term="+id
            self.artigos.append(artigo)

        self.novosAutores = list(set(self.novosAutores))
        return

    def parse(self):
        # print("Parse")
        return

    def save(self):
        print("Save")
        for autor in self.novosAutores:
            self.database.insert("autores", {"nome": autor})
        for artigo in self.artigos:
            self.database.insert("artigos", artigo['dados'])
            id = self.database.find("artigos", where=[" link like %s" % (artigo['dados']['link'],)], colunas=['id'], ordem='order by id desc limit 1')
            a = 'INSERT INTO autores_artigos (idArtigo, idAutor) Select '+str(id[0]['id'])+' as idArtigo, id as idAutor From autores Where autores.nome in ("' + ('", "'.join(artigo['autores'])) + '")'
            self.database.execute(a)
        return