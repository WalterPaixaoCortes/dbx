<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;

class ProteinaForm extends Model
{
    public $nome;
    public $dados;
    public $id;

    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['dados', 'id'], 'default']
        ];
    }

}
