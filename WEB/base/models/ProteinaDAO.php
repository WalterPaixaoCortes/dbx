<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db;
use Yii;

class ProteinaDAO extends ActiveRecord
{

    public static function tableName()
    {
        return "proteinas";
    }

    public static function findIdentity($id)
    {
        return ProteinaDAO::findOne(['id'=>$id]);
    }

    public function adicionar($nome, $dados = null){
        $this->nome = $nome;
        $this->dados = $dados;
        return $this->save();
    }

    public function remover()
    {
        $p = \Yii::$app->db->createCommand("Select count(*) as n from ((SELECT DISTINCT(proteina) FROM `componentescoletarefinamento` where proteina = ".$this->id.") UNION (Select DISTINCT(proteina) FROM artigos where proteina = ".$this->id.")) as a")->queryAll();
        if($p[0]['n'] > 0){
            return false;
        }
        return (ProteinaDAO::deleteAll('id = '.$this->id) > 0);
    }

    /**
     * @inheritdoc
     */
    public static function listarPag($start = 0, $count = 10, $nome = '', $estrutura = '')
    {
        $where = '';
        if($nome != '') {
            $where = "inner join proteinas on proteinas.id = componentescoletarefinamento.proteina where proteinas.nome like '%" . $nome . "%' ";
        }
        $q = Yii::$app->db->createCommand('Select proteina, nometabela, componentescoletarefinamento.id as id from componentescoletarefinamento '.$where)->queryAll();
        $novaq = "";
        $controle = false;

        $wEstrutura = '';
        if($estrutura != '') {
            $wEstrutura = " where estrutura like '%" . $estrutura . "%' ";
        }

        foreach ($q as $resultado) {
            if($controle){
                $novaq .= " UNION ";
            }else {
                $controle = true;
            }
            $novaq .= '(Select * From (SELECT nome, id as idProteina FROM proteinas where proteinas.id = '.$resultado['proteina'].') as fds CROSS JOIN (Select "'.$resultado['id'].'" as idComponente, estrutura, id as idTabela from '.$resultado['nometabela'].' '.$wEstrutura.') as tabelacomponente)';
        }
        $q = Yii::$app->db->createCommand('Select * from ('.$novaq.') as ok limit '.$count.' offset '.$start)->queryAll();
        $qt = Yii::$app->db->createCommand('Select count(*) as pags from ('.$novaq.') as ok;')->queryAll();

        return ["lista" => $q, "pags"=>(int)($qt[0]['pags']/$count)+1];
    }

    /**
     * @inheritdoc
     */
    public static function listarProteinasPag($start = 0, $count = 10, $nome = '')
    {
        $where = '';
        if($nome != '') {
            $where = "where proteinas.nome like '%" . $nome . "%' ";
        }

        $q = Yii::$app->db->createCommand('Select * from proteinas '.$where.' limit '.$count.' offset '.$start)->queryAll();
        $qt = Yii::$app->db->createCommand('Select count(*) as pags from proteinas '.$where.';')->queryAll();

        return ["lista" => $q, "pags"=>(int)($qt[0]['pags']/$count)+1];
    }
}
