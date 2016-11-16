<?php

namespace app\controllers;

use app\models\ArtigoDAO;
use app\models\ArtigoForm;
use app\models\ComponenteColetaDAO;
use app\models\UploadRefinamentoForm;
use app\models\UploadColetaForm;
use app\models\UploadForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\UploadedFile;
use ZipArchive;

class ArtigoController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ArtigoForm();
        $count = 10;
        $start = 0;
        $filtro = [];
        $filtro['pag'] = 1;
        $filtro['pags'] = 1;
        $filtro['count'] = $count;
        $filtro['titulo'] = '';
        $filtro['proteina'] = '';
        $filtro['autor'] = '';

        if(Yii::$app->request->get('pag') != null && Yii::$app->request->get('pag') != ''){
            $filtro['pag'] = Yii::$app->request->get('pag');
            $start = ($filtro['pag']-1)*$count;
        }

        if ($model->load(Yii::$app->request->post())) {
            $filtro['titulo'] = $model->titulo;
            $filtro['proteina'] = $model->proteina;
            $filtro['autor'] = $model->autor;
            $artigos = ArtigoDAO::listPag($start, $count, $model->titulo, $model->proteina, $model->autor);
            $filtro['pags'] = ArtigoDAO::countPags($start, $count, $model->titulo, $model->proteina, $model->autor);
        }else{
            if(Yii::$app->request->get('titulo') != ''){
                $filtro['titulo'] = Yii::$app->request->get('titulo');
            }
            if(Yii::$app->request->get('proteina') != ''){
                $filtro['proteina'] = Yii::$app->request->get('proteina');
            }
            if(Yii::$app->request->get('autor') != ''){
                $filtro['autor'] = Yii::$app->request->get('autor');
            }
            $artigos = ArtigoDAO::listPag($start, $count, $filtro['titulo'], $filtro['proteina'], $filtro['autor']);

            $filtro['pags'] = ArtigoDAO::countPags($start, $count, $filtro['titulo'], $filtro['proteina'], $filtro['autor']);
        }
        return $this->render("Index", ['model'=>$model,'artigos' => $artigos, 'filtro'=>$filtro]);
    }
}
