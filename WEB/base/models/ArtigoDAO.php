<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db;

class ArtigoDAO extends Model
{
    /*public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;*/

    public static function tableName()
    {
        return "artigos";
    }

    /**
     * @inheritdoc
     */
    public static function listPag($start = 0, $count = 10, $titulo = '', $proteina='', $autor='')
    {
        $where = '';
        $i = false;
        if($titulo != '') {
            if(!$i){
                $i = true;
                $where = ' Where ';
            }else{
                $where = $where.' AND ';
            }
            $where = $where."artigos.titulo like '%" . $titulo . "%' ";
        }
        if($proteina != '') {
            if(!$i){
                $i = true;
                $where = ' Where ';
            }else{
                $where = $where.' AND ';
            }
            $where = $where."proteinas.nome like '%" . $proteina . "%'";
        }
        if($autor != '') {
            if(!$i){
                $i = true;
                $where = ' Where ';
            }else{
                $where = $where.' AND ';
            }
            $where = $where."autores.nome like '%" . $autor . "%'";
        }

        $q = \Yii::$app->db->createCommand('Select a.*, autores.nome as autor from (
                                                Select distinct(artigos.id) as id, artigos.titulo, artigos.abstract, artigos.data, proteinas.nome as proteina From artigos 
                                                left join proteinas on proteinas.id = artigos.proteina
                                                inner join autores_artigos on autores_artigos.idArtigo = artigos.id 
                                                inner join autores on autores.id = autores_artigos.idAutor  
                                                '.$where.'
                                                order by artigos.data, artigos.id limit '.$count.' offset '.$start.'
                                            ) AS a  
                                            inner join autores_artigos on autores_artigos.idArtigo = a.id 
                                            inner join autores on autores.id = autores_artigos.idAutor                   
                                            ')->queryAll();
        return $q;
    }


    public static function countPags($start = 0, $count = 10, $titulo = '', $proteina='', $autor='')
    {
        $where = '';
        $i = false;
        if($titulo != '') {
            if(!$i){
                $i = true;
                $where = ' Where ';
            }else{
                $where = $where.' AND ';
            }
            $where = $where."artigos.titulo like '%" . $titulo . "%' ";
        }
        if($proteina != '') {
            if(!$i){
                $i = true;
                $where = ' Where ';
            }else{
                $where = $where.' AND ';
            }
            $where = $where."proteinas.nome like '%" . $proteina . "%'";
        }
        if($autor != '') {
            if(!$i){
                $i = true;
                $where = ' Where ';
            }else{
                $where = $where.' AND ';
            }
            $where = $where."autores.nome like '%" . $autor . "%'";
        }

        $q = \Yii::$app->db->createCommand('Select count(*) as pags From artigos 
                                                left join proteinas on proteinas.id = artigos.proteina
                                                inner join autores_artigos on autores_artigos.idArtigo = artigos.id 
                                                inner join autores on autores.id = autores_artigos.idAutor  
                                                '.$where)->queryAll();

        return (int)($q[0]['pags']/$count)+1;
    }
}
