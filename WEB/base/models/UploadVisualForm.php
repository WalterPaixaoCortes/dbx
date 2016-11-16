<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;

class UploadVisualForm extends UploadForm
{

    function __construct($config = [])
    {
        parent::__construct($config);
        $this->dir = $this->dir.'/Visual';
    }

    public function rules()
    {
        return [
            [['file'], 'file'],
        ];
    }

    public function validar()
    {
        if($this->file == null){
            $this->addError('file', 'É necessário selecionar um arquivo .html');
            return false;
        }
        if($this->file->type != "text/html"){
            $this->addError('file', 'É necessário selecionar um arquivo .html');
            return false;
        }
        if ($this->validate()) {
            return true;
        }else{
            $this->addError('file', 'Arquivo inválido');
        }
    }

    public function salvar(){
        if(!$this->validar()){
            return false;
        }
        try {
            $dirArquivo = $this->dir . "/" . $this->file->baseName . "." . $this->file->extension;
            $this->file->saveAs($dirArquivo);
            exec("chmod 777 ".$this->dir . "/" . $this->file->baseName . "." . $this->file->extension);
            $componente = new ComponenteVisualDAO();
            $componente->nome = $this->file->baseName;
            $componente->save();
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
