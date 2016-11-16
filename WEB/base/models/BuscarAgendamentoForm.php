<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use ZipArchive;
use DateTime;

class BuscarAgendamentoForm extends Model
{
    public $nome;

    public function rules()
    {
        return [
            [['nome'], 'default']
        ];
    }

}
