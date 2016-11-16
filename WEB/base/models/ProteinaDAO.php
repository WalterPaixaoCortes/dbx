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
        return ProteinaDAO::findOne(['id' => $id]);
    }

    public function findEstrutura($componente, $id)
    {
        $q = Yii::$app->db->createCommand("Select proteinas.nome as proteina, nometabela as nometabela, componentesvisuais.nome as componentevisual from componentescoletarefinamento inner join componentesvisuais on componentesvisuais.id = componentescoletarefinamento.componentevisual inner join  proteinas on proteinas.id = componentescoletarefinamento.proteina where componentescoletarefinamento.id = " . $componente . " limit 1")->queryAll();
        if (empty($q)) {
            $q['estrutura'] = null;
            return $q;
        }
        $q = $q[0];
        $q['estrutura'] = Yii::$app->db->createCommand("Select * from " . $q['nometabela'] . " where id = " . $id . "")->queryAll()[0];
        return $q;
    }

    public function adicionar($nome, $dados = null)
    {
        $this->nome = $nome;
        $this->dados = $dados;
        return $this->save();
    }

    public function remover()
    {
        $p = \Yii::$app->db->createCommand("Select count(*) as n from ((SELECT DISTINCT(proteina) FROM `componentescoletarefinamento` where proteina = " . $this->id . ") UNION (Select DISTINCT(proteina) FROM artigos where proteina = " . $this->id . ")) as a")->queryAll();
        if ($p[0]['n'] > 0) {
            return false;
        }
        return (ProteinaDAO::deleteAll('id = ' . $this->id) > 0);
    }

    public static function listarPag($start = 0, $count = 10, $nome = '', $estrutura = '', $ligantes = '')
    {
        $where = '';
        $join = '';
        if ($nome != '') {
            $where = " AND proteinas.nome like '%" . $nome . "%' ";
            $join = "inner join proteinas on proteinas.id = componentescoletarefinamento.proteina";
        }
        $q = Yii::$app->db->createCommand('Select proteina, nometabela, componentescoletarefinamento.id as id from componentescoletarefinamento ' . $join . " Where componentescoletarefinamento.proteina IS NOT NULL AND componentescoletarefinamento.NomeTabela IS NOT NULL AND componentescoletarefinamento.componenteVisual IS NOT NULL " . $where)->queryAll();
        $novaq = "";
        $controle = false;

        $where = '';

        if ($estrutura != '') {
            $where = " Where estrutura like '%" . $estrutura . "%' ";
        }

        if ($ligantes != '') {
            $where .= ($where == '' ? " Where ligantes like '%" . $ligantes . "%' " : " And ligantes like '%".$ligantes."%' ");
        }


        if (empty($q)) {
            return ["lista" => [], "pags" => 0];
        }
        foreach ($q as $resultado) {
            if ($controle) {
                $novaq .= " UNION ";
            } else {
                $controle = true;
            }
            $novaq .= '(Select * From (SELECT nome, id as idProteina FROM proteinas where proteinas.id = ' . $resultado['proteina'] . ') as fds CROSS JOIN (Select "' . $resultado['id'] . '" as idComponente, estrutura, ligantes, id as idEstrutura from ' . $resultado['nometabela'] . ' ' . $where . ') as tabelacomponente)';
        }
        $q = Yii::$app->db->createCommand('Select * from (' . $novaq . ') as ok limit ' . $count . ' offset ' . $start)->queryAll();
        $qt = Yii::$app->db->createCommand('Select count(*) as pags from (' . $novaq . ') as ok;')->queryAll();
        $p = (int)($qt[0]['pags'] / $count);
        return ["lista" => $q, "pags" =>  ($p>0?$p:1)];
    }

    public static function listarProteinasPag($start = 0, $count = 10, $nome = '')
    {
        $where = '';
        if ($nome != '') {
            $where = "where proteinas.nome like '%" . $nome . "%' ";
        }

        $q = Yii::$app->db->createCommand('Select * from proteinas ' . $where . ' limit ' . $count . ' offset ' . $start)->queryAll();
        $qt = Yii::$app->db->createCommand('Select count(*) as pags from proteinas ' . $where . ';')->queryAll();

        return ["lista" => $q, "pags" => (int)($qt[0]['pags'] / $count) + 1];
    }
}
