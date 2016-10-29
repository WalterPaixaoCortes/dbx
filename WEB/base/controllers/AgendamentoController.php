<?php

namespace app\controllers;

use app\models\AgendamentoDAO;
use app\models\AgendamentoForm;
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

class AgendamentoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'lista',  'remover', 'adicionar'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
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
        return $this->render("Index");
    }

    public function actionAdicionar()
    {
        $model = new AgendamentoForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->validacao();
            if(!$model->hasErrors()) {
                $componentes = str_getcsv(Yii::$app->request->post('ordem'), ";");
                $dao = new AgendamentoDAO();
                $dao->componentes = $componentes;
                $dao->nome = $model->nome;
                $dao->comentario = $model->comentario;
                $dao->inicio = $model->data;
                $dao->intervalo = $model->intervalo;
                if($dao->salvar()){
                    Yii::$app->getSession()->setFlash('msg', "Agendamento salvo!");
                    return $this->redirect(['agendamento/index']);
                }
                Yii::$app->getSession()->setFlash('msg', "Erro ao tentar salvar o agendamento.");
            }
        }
        return $this->render("Agendamento", ['model'=>$model]);
    }
}
