<?php

namespace app\models;

use Yii;
use yii\base\Model;
use ZipArchive;
use DateTime;

class AgendamentoForm extends Model
{
    public $nome;
    public $comentario;
    public $inicio;
    public $intervalo = 7;
    public $data;
    public $hora = 00;
    public $minuto = 00;
    public $id;
    public $paralelismo = true;

    public function rules()
    {
        return [
            [['nome'], 'required'],
            ['data', 'default'],
            ['paralelismo', 'default'],
            [['intervalo'], 'integer', 'integerOnly'=>true, 'min'=>1],
            [['hora', 'minuto', 'inicio'], 'required'],
            [['comentario'], 'string', 'length'=>[0,255]],
            [['id', 'hora', 'minuto'], 'default'],
        ];
    }

    public function validacao(){
        try{
            $d = "".$this->inicio." ".$this->hora.":".$this->minuto.":00";
            $this->data = DateTime::createFromFormat("d/m/Y H:i:s", "".$d);
            if($this->data == false){
                $this->addError("inicio", "Data ou Horário inválido1");
                return false;
            }
            $this->data = $this->data->getTimestamp();
            if(!(date("d/m/Y H:i:s", $this->data)."" == $d)){
                $this->addError("inicio", "Data ou Horário inválido2");
                return false;
            }
            $this->data = date("Y/m/d H:i:s", $this->data);
        }catch (Exception $e){
            $this->addError("inicio", "Data ou Horário inválido3");
        }
    }
}
