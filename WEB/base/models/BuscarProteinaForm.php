<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;


class BuscarProteinaForm extends Model
{
    public $nome;
    public $estrutura;
    public $ligantes;

    public function rules()
    {
        return [
            [['nome', 'estrutura', 'ligantes'], 'default'],
        ];
    }

}
