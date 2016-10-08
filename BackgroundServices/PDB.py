from Bio.PDB import *

#Object
def parse(self):
    parser = PDBParser()
    structure = parser.get_structure('PHA-L', '1FAT.cif') #modificar os parametros
    return structure

def get_file(self):
    #pdbl = PDBList()
    #pdbl.retrieve_pdb_file('1FAT')
    return