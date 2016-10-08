import mysql.connector
from mysql.connector import errorcode
DB_NAME = 'db'


TABLES = {}

TABLES['componentescoletarefinamento'] = ("CREATE TABLE `componentescoletarefinamento` ( "
    "`ID` int(10) UNSIGNED NOT NULL, "
    "`Nome` varchar(255) NOT NULL, "
    "`Tipo` char(3) NOT NULL, "
    "`proteina` int(11) DEFAULT NULL, "
    "`NomeTabela` varchar(255) DEFAULT NULL, "
    "`Configuracao` text, "
    "`Criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, "
    "`Alteracao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP "
    ") ENGINE=MyISAM DEFAULT CHARSET=latin1; ")

cn = mysql.connector.connect(user='dbx', password = 'dbx')

cr = cn.cursor()

def create_database(pcr):
    try:
        pcr.execute("CREATE DATABASE {} DEFAULT CHARACTER SET 'utf8'".format(DB_NAME))
    except mysql.connector.Error as err:
        print ("Failed creating database: {}".format(err))
        exit(1)

#def create_tables(tbl):
#   for name, dd1 in tbl.items()