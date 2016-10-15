import xml.etree.ElementTree as xml

class Arquivo:

    def abrir_xml(self, dir):
        dados = xml.parse(dir)
        root = dados.getroot()
        return self.xml_child(root, {})

    def xml_child(self, x, dic):
        if len(x) > 0:
            chave = {}
            for a in x:
                chave.update(self.xml_child(a, dic))
            return {x.tag:chave}
        return {x.tag:x.text}

    def abrir_txt(self, dir):
        return