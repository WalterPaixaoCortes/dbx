<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;

/**
 * LoginForm is the model behind the login form.
 *
 * @property UserDAO|null $user This property is read-only.
 *
 */
class UploadForm extends Model
{

    public $file;
    public $dir = '../../../Componentes';

    function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['file'], 'file', 'required', 'skipOnEmpty'=>false, 'extensions' => 'zip'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
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

    public function carregarArquivos($d){
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
            $this->carregarArquivos($this->dir .'/'.$this->file->baseName);
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
