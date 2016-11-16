<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;

class ComponenteColetaForm extends Model
{
    public $nome;
    public $proteinas = [];
    public $visual;

    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['visual'], 'default']
        ];
    }

}
