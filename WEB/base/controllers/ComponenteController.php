<?php

namespace app\controllers;

use app\models\ComponenteColetaDAO;
use app\models\ComponenteVisualDAO;
use app\models\UploadRefinamentoForm;
use app\models\UploadColetaForm;
use app\models\UploadForm;
use app\models\UploadVisualForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\UploadedFile;
use ZipArchive;

class ComponenteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['upload-coleta'],
                'rules' => [
                    [
                        'actions' => ['upload-refinamento', 'upload-coleta', 'upload-visual', 'index', 'componentes-coleta', 'remover-coleta',  'componentes-visuais', 'remover-visual'],
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

    public function actionComponentesColeta()
    {
        return $this->render("ListaColeta", ['componentes'=>ComponenteColetaDAO::listAll()]);
    }

    public function actionComponentesVisuais()
    {
        return $this->render("ListaVisual", ['componentes'=>ComponenteVisualDAO::listAll()]);
    }

    public function actionRemoverColeta()
    {
        $componente = Yii::$app->request->get('componente');
        if(isset($componente) && $componente > 0){
            $c = ComponenteColetaDAO::findIdentity($componente);
            if($c->remover()){
                \Yii::$app->getSession()->setFlash('msg', "Componente removido.");
            }else{
                \Yii::$app->getSession()->setFlash('msg', "Erro ao tentar remover componente.");
            }
        }
        return $this->redirect(['componente/componentes-coleta']);
    }

    public function actionRemoverVisual()
    {
        $componente = Yii::$app->request->get('componente');
        if(isset($componente) && $componente > 0){
            $c = ComponenteVisualDAO::findIdentity($componente);
            if($c->remover()){
                \Yii::$app->getSession()->setFlash('msg', "Componente removido.");
            }else{
                \Yii::$app->getSession()->setFlash('msg', "O componente visual está vinculado e não pode ser removido.");
            }
        }
        return $this->redirect(['componente/componentes-visuais']);
    }

    public function actionUploadColeta()
    {
        $model = new UploadColetaForm();
        if ($model->load(Yii::$app->request->post())) {
            if($this->upload($model)){
                return $this->redirect(['componente/componentes-coleta']);
            }
        }
        return $this->render('UploadColeta', [
            'model' => $model,
        ]);
    }

    public function actionUploadRefinamento()
    {
        $model = new UploadRefinamentoForm();
        if ($model->load(Yii::$app->request->post())) {
            if($this->upload($model)){
                return $this->redirect(['componente/componentes-refinamento']);
            }
        }
        return $this->render('UploadRefinamento', [
            'model' => $model,
        ]);
    }

    public function actionUploadVisual()
    {
        $model = new UploadVisualForm();
        if ($model->load(Yii::$app->request->post())) {
            if($this->upload($model)){
                return $this->redirect(['componente/componentes-visuais']);
            }
        }
        return $this->render('UploadVisual', ['model' => $model]);
    }

    private function upload($model)
    {
        $model->file = UploadedFile::getInstance($model, 'file');
        return $model->salvar();
    }
}
