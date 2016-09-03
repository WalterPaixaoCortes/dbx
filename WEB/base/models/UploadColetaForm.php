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
class UploadColetaForm extends UploadForm
{

    function __construct($config = [])
    {
        parent::__construct($config);
        $this->dir = $this->dir.'/Coleta';
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

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validar()
    {
        if ($this->validate()) {
            return true;
        }else{
            $this->addError('file', 'Arquivo inválido');
        }
    }

    public function verificarArquivos($zip){
//        for($i = 0; $i < $zip->numFiles; $i++){
//            var_dump($zip->getFromIndex($i));
//        }
//        die(var_dump($this->dir));
        return true;
    }
}
