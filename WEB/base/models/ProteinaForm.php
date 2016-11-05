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
class ProteinaForm extends Model
{
    public $nome;
    public $dados;
    public $id;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            //[['file'], 'file', 'required', 'skipOnEmpty'=>false, 'extensions' => 'zip'],
            [['nome'], 'required'],
            [['dados', 'id'], 'default']
        ];
    }

}
