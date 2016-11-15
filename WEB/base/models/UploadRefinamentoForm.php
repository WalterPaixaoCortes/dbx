<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;
use DOMDocument;
use SimpleXMLElement;

/**
 * LoginForm is the model behind the login form.
 *
 * @property UserDAO|null $user This property is read-only.
 *
 */
class UploadRefinamentoForm extends UploadForm
{

    function __construct($config = [])
    {
        parent::__construct($config);
        $this->dir = $this->dir.'/Refinamento';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['file'], 'file', 'extensions' => 'zip'],
        ];
    }

    public function verificarArquivos($zip){
        try {
            $main = "" . $zip->getFromName("Main.py");
            if (!(strpos($main, "class Main(ComponenteColeta):") &&
                strpos($main, "def extract(self):") &&
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

        return true;
    }

    public function carregar($d)
    {
        if (!is_dir($d)) {
            $this->addError('file', 'Erro ao carregar os arquivos.');
            return false;
        }

        try {
            $xml = simplexml_load_file($d . "/Config.xml");
            $componente = $xml['nome'] . "";
            if($componente == ""){
                return false;
            }

            $comp = new ComponenteRefinamentoDAO();
            $comp->adicionar($componente);
        }catch (Exception $e){
            $this->addError('file', 'Erro ao carregar os arquivos.');
            return false;
        }
        return true;
    }
}
