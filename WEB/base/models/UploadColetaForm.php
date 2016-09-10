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

    public function verificarArquivos($zip){
//        for($i = 0; $i < $zip->numFiles; $i++){
//            var_dump($zip->getFromIndex($i));
//        }
//        die(var_dump($this->dir));
        return true;
    }
}
