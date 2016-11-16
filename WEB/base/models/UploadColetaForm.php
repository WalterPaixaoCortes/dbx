<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;
use DOMDocument;
use SimpleXMLElement;

class UploadColetaForm extends UploadForm
{

    function __construct($config = [])
    {
        parent::__construct($config);
        $this->dir = $this->dir . '/Coleta';
    }

    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'zip'],
        ];
    }

    public function verificarArquivos($zip)
    {
        //Verificacao da classe principal
        try {
            $main = "" . $zip->getFromName("Main.py");
            if (!(strpos($main, "class Main(ComponenteColeta):") &&
                strpos($main, "def extract(self):") &&
                strpos($main, "def parse(self):") &&
                strpos($main, "def save(self):"))
            ) {
                $this->addError('file', 'Arquivo Main.py inválido.');
                return false;
            }

        } catch (ErrorException $e) {
            $this->addError('file', 'Arquivo Main.py inválido.');
            return false;
        }

        //Verificacao Config.xml
        try {
            $dom = new DOMDocument();
            $dom->loadXML($zip->getFromName("Config.xml"));
        } catch (ErrorException $e) {
            $this->addError('file', 'Arquivo Config.xml inválido.');
            return false;
        }

        //Verificacao Estrutura.xml
        try {
            $dom = new DOMDocument();
            $dom->loadXML($zip->getFromName("Estrutura.xml"));
        } catch (ErrorException $e) {
            $this->addError('file', 'Arquivo Estrutura.xml inválido.');
            return false;
        }

        return true;
    }

    public function carregar($d)
    {
        if (!is_dir($d)) {
            $this->addError('file', 'Erro ao carregar os arquivos.');
            return false;
        }

        $tabela = new Tabela();

        $xml = simplexml_load_file($d . "/Config.xml");
        $tabela->proteinas = $xml->proteina;

        $xml = simplexml_load_file($d . "/Estrutura.xml");
        $tabela->componente = $xml['nome']."";
        $tabela->tipo = "col";

        foreach ($xml->tabela as $t){
            $tabela->nome = $t['nome'];
            foreach ($t->coluna as $coluna) {
                $c = [];
                $c['nome'] = $coluna->nome."";
                $c['formato'] = $coluna->formato."";
                $c['pk'] = false;
                if(isset($coluna['pk']) && $coluna['pk']."" == "true"){
                    $c['pk'] = true;
                }
                $tabela->colunas[] = $c;
            }

            if(!$tabela->criar()){
                $this->addError('file', 'Erro ao criar a base de dados.');
                return false;
            }
            return true;
        }
        $comp = new ComponenteColetaDAO();
        $comp->adicionar($tabela->componente, $tabela->proteinas);
        return true;
    }
}
