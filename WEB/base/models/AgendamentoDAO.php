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

    public static function findIdentity($id){
        $a = AgendamentoDAO::findOne(['id'=>$id]);
        $a->carregarComponentes();
        return $a;
    }

    public static function listPag($start = 0, $count = 10, $nome='')
    {
        $where = '';

        if($nome != '') {
            $where = "And agendamentos.nome like '%" . $nome . "%'";
        }

        $q = \Yii::$app->db->createCommand('SELECT * FROM agendamentos 
                                                Where ativo = 1 '.$where.'
                                                order by ativo, agendamentos.inicio desc, id desc limit '.$count.' offset '.$start.'
                                            ')->queryAll();
        $qt = \Yii::$app->db->createCommand('SELECT count(*) as pags FROM agendamentos 
                                                Where ativo = 1 '.$where.'
                                            ')->queryAll();
        return ["lista" => $q, "pags"=>(int)($qt[0]['pags']/$count)+1];
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
            \Yii::$app->db->createCommand("INSERT INTO agendamentos_componentes(idAgendamento, idComponente, ordem) Select DISTINCT ".$this->id.", componentescoletarefinamento.Nome, ".$i." From componentescoletarefinamento  where componentescoletarefinamento.id = ".$comp.";")->execute();
            $i++;
        }
        return true;
    }

    public function atualizar(){
        \Yii::$app->db->createCommand("Delete From agendamentos_componentes Where idAgendamento = ".$this->id.";")->execute();
        return $this->salvar();
    }

    public function remover(){
        if($this->id == null){
            return false;
        }
        $this->ativo = 0;
        return $this->save();
    }

    public function carregarComponentes(){
        $c = \Yii::$app->db->createCommand("Select componentescoletarefinamento.ID From agendamentos_componentes inner join componentescoletarefinamento on componentescoletarefinamento.Nome = agendamentos_componentes.idComponente Where idAgendamento = ".$this->id." order by ordem;")->queryAll();
        $this->componentes = [];
        foreach ($c as $comp){
            $this->componentes[] = $comp['ID'];
        }
    }
}
