<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db;

class AgendamentoDAO extends ActiveRecord
{

    public $componentes = [];

    public static function tableName()
    {
        return "agendamentos";
    }

    /**
     * @inheritdoc
     */
    public static function listPag($start = 0, $count = 10, $nome='')
    {
        $where = '';
        $i = false;

        if($nome != '') {
            $where = "Where agendamentos.nome like '%" . $nome . "%'";
        }

        $q = \Yii::$app->db->createCommand('SELECT * FROM agendamentos 
                                                '.$where.'
                                                order by agendamentos.inicio desc limit '.$count.' offset '.$start.'
                                            ')->queryAll();
        return $q;
    }

    public function salvar(){
        $c = \Yii::$app->db->createCommand('SELECT id FROM componentescoletarefinamento')->queryAll();
        $i1 = 0;
        $i2 = 0;
        foreach ($this->componentes as $comp){
            if($comp == ''){
                continue;
            }
            $i1++;
            foreach ($c as $c2){
                if($c2['id'] == $comp){
                  $i2++;
                    break;
                }
            }
        }
        if($i1 != $i2){
            return false;
        }
        if(!$this->save()){
            return false;
        }
        $i = 0;
        foreach ($this->componentes as $comp){
            if($comp == ''){continue;}
            \Yii::$app->db->createCommand("INSERT INTO agendamentos_componentes (idAgendamento, idComponente, ordem) VALUES (".$this->id.", ".$comp.",".$i.");")->execute();
            $i++;
        }
        return true;
    }
}
