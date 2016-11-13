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

    public function criar(){

        $pk = '';
        $cmd = [];
        foreach ($this->colunas as $coluna){
            if($coluna['pk']){
                $pk = $pk.$coluna['nome'].",";
            }
            $cmd[] = $coluna['nome']." ".$coluna['formato'];
        }
        $cmd = join(", ", $cmd);
        if($pk == ''){
            $cmd = 'Create Table IF NOT EXISTS '.$this->nome.' ( id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, '.$cmd." )";
        }else{
            $cmd = 'Create Table IF NOT EXISTS '.$this->nome.' ('.$cmd." PRIMARY KEY (".substr($pk,0, strlen($pk)-1)."));";
        }

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try{
            $db->createCommand($cmd)->execute();
            $db->createCommand("INSERT INTO componentescoletarefinamento (ID, Nome, Tipo, NomeTabela, Configuracao, Criacao, Alteracao) VALUES (NULL, '".$this->componente."', '".$this->tipo."', '".$this->nome."', '', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);")->execute();
            $transaction->commit();
            return true;
        }catch (Exception $e){
            die(var_dump($e));
            $transaction->rollBack();
            return false;
        }
    }
}
