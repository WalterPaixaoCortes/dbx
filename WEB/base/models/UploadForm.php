<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;

class UploadForm extends Model
{

    public $file;
    public $dir = '../../../BackgroundServices/Componentes';

    function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['file'], 'file', 'required', 'skipOnEmpty'=>false, 'extensions' => 'zip'],
        ];
    }

    public function validar()
    {
        if($this->file == null){
            $this->addError('file', 'É necessário selecionar um arquivo .zip');
            return false;
        }
        if ($this->validate()) {
            return true;
        }else{
            $this->addError('file', 'Arquivo inválido');
        }
    }

    public function verificarArquivos($zip){
       return false;
    }

    public function carregar($d){
        return false;
    }

    public function salvar(){
        if(!$this->validar()){
            return false;
        }
        try {
            $dirArquivo = $this->dir . "/" . $this->file->baseName . "." . $this->file->extension;
            $this->file->saveAs($dirArquivo);
            $zip = new ZipArchive();
            $zip->open($dirArquivo);
            if(!$this->verificarArquivos($zip)){
                return false;
            }
            $zip->extractTo($this->dir .'/'.$this->file->baseName);
            $zip->close();
            exec("chmod 777 ".$this->dir .'/'.$this->file->baseName);
            $f = fopen($this->dir .'/'.$this->file->baseName."/__init__.py", "w+");
            fclose($f);
            if(!$this->carregar($this->dir .'/'.$this->file->baseName)){
                $this->addError('file', 'Erro ao carregar os arquivos.');
                return false;
            }
        }catch (Exception $e){
            $this->addError('file', 'Erro ao tentar enviar o arquivo.');
            return false;
        }
        if($this->hasErrors()){
            return false;
        }
        return true;
    }
}
