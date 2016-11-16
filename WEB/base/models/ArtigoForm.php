<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;

class ArtigoForm extends Model
{
    public $titulo;
    public $data;
    public $proteina;
    public $autor;

    public function rules()
    {
        return [
            [['titulo', 'proteina', 'autor'], 'default'],
        ];
    }

}
