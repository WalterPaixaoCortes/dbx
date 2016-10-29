<?php

namespace app\models;

use Yii;
use yii\base\Model;
use ZipArchive;
use DateTime;
/**
 * LoginForm is the model behind the login form.
 *
 * @property UserDAO|null $user This property is read-only.
 *
 */
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
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            //[['file'], 'file', 'required', 'skipOnEmpty'=>false, 'extensions' => 'zip'],
            [['nome'], 'required'],
            ['data', 'default'],
            [['intervalo'], 'integer', 'integerOnly'=>true, 'min'=>1],
            [['hora', 'minuto', 'inicio'], 'required'],
            [['comentario'], 'string', 'length'=>[0,255]],
            [['id', 'hora', 'minuto'], 'default'],
        ];
    }

    public function validacao(){
        try{
//            if($this->minuto < 10){
//                $this->minuto = "0".$this->minuto;
//            }
            $d = "".$this->inicio." ".$this->hora.":".$this->minuto.":00";
            $this->data = DateTime::createFromFormat("j/n/Y H:i:s", "".$d);
            if($this->data == false){
                $this->addError("inicio", "Data ou Horário inválido");
                return false;
            }
            $this->data = $this->data->getTimestamp();
            if(!(date("j/n/Y H:i:s", $this->data)."" == $d)){
                $this->addError("inicio", "Data ou Horário inválido");
                return false;
            }
            $this->data = date("Y/m/d H:i:s", $this->data);
        }catch (Exception $e){
            $this->addError("inicio", "Data ou Horário inválido");
        }
    }
}
