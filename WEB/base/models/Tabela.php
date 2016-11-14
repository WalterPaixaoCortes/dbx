<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;
use yii\db\Exception;

class Tabela
{
    public $componente;
    public $nome;
    public $colunas = [];
    public $tipo;
    public $proteinas = [];

    public function criar()
    {

        $pk = '';
        $cmd = [];
        foreach ($this->colunas as $coluna) {
            if ($coluna['pk']) {
                $pk = $pk . $coluna['nome'] . ",";
            }
            $cmd[] = $coluna['nome'] . " " . $coluna['formato'];
        }
        $cmd = join(", ", $cmd);
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        foreach ($this->proteinas as $p) {
            if ($pk == '') {
                $comd = 'Create Table IF NOT EXISTS ' . $this->nome . "_" . $p . ' ( id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, ' . $cmd . " )";
            } else {
                $comd = 'Create Table IF NOT EXISTS ' . $this->nome . "_" . $p . ' (' . $cmd . " PRIMARY KEY (" . substr($pk, 0, strlen($pk) - 1) . "));";
            }
            try {
                $db->createCommand($comd)->execute();
                $db->createCommand(
                    "INSERT INTO componentescoletarefinamento (Nome, Tipo, NomeTabela, Configuracao, Criacao, Alteracao) 
                      VALUES ('" . $this->componente . "', '" . $this->tipo . "', '" . $this->nome. "_" . $p . "', '".$p."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);")->execute();
            } catch (Exception $e) {
//                die(var_dump($e));
                $transaction->rollBack();
                return false;
            }
        }
        $transaction->commit();
        return true;
    }
}
