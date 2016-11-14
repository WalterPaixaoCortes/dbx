<?php

namespace app\controllers;

use app\models\ArtigoDAO;
use app\models\ArtigoForm;
use app\models\BuscarProteinaForm;
use app\models\ComponenteColetaDAO;
use app\models\ProteinaDAO;
use app\models\ProteinaForm;
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

class ProteinaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'lista',  'remover', 'adicionar'],
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
        return $this->redirect(['proteina/lista']);
    }

    public function actionLista()
    {
        $model = new BuscarProteinaForm();
        $count = 10;
        $start = 0;
        $filtro = [];
        $filtro['pag'] = 1;
        $filtro['pags'] = 1;
        $filtro['count'] = $count;
        $filtro['nome'] = '';
        $resultado = [];

        if(Yii::$app->request->get('pag') != null && Yii::$app->request->get('pag') != ''){
            $filtro['pag'] = Yii::$app->request->get('pag');
            $start = ($filtro['pag']-1)*$count;
        }

        if ($model->load(Yii::$app->request->post())) {
            $filtro['nome'] = $model->nome;
            $resultado =  ProteinaDAO::listarProteinasPag($start, $count, $model->nome);
            $proteinas = $resultado['lista'];
            $filtro['pags'] = $resultado['pags'];
        }else{
            if(Yii::$app->request->get('nome') != ''){
                $filtro['nome'] = Yii::$app->request->get('nome');
            }
            $resultado =  ProteinaDAO::listarProteinasPag($start, $count, $filtro['nome']);
            $proteinas = $resultado['lista'];
            $filtro['pags'] = $resultado['pags'];
        }

        return $this->render("Lista", ["filtro"=>$filtro, "proteinas"=>$proteinas, "model"=>$model]);
    }


    public function actionBusca()
    {
        $model = new BuscarProteinaForm();
        $count = 10;
        $start = 0;
        $filtro = [];
        $filtro['pag'] = 1;
        $filtro['pags'] = 1;
        $filtro['count'] = $count;
        $filtro['nome'] = '';
        $filtro['estrutura'] = '';
        $filtro['ligantes'] = '';
        $resultado = [];


        if ($model->load(Yii::$app->request->post())) {
            $filtro['nome'] = $model->nome;
            $filtro['estrutura'] = $model->estrutura;
            $filtro['ligantes'] = $model->ligantes;
            $resultado =  ProteinaDAO::listarPag($start, $count, $model->nome, $model->estrutura, $model->ligantes);
            $proteinas = $resultado['lista'];
            $filtro['pags'] = $resultado['pags'];
        }else{
            if(Yii::$app->request->get('pag') != null && Yii::$app->request->get('pag') != ''){
                $filtro['pag'] = Yii::$app->request->get('pag');
                $start = ($filtro['pag']-1)*$count;
            }
            if(Yii::$app->request->get('nome') != ''){
                $filtro['nome'] = Yii::$app->request->get('nome');
            }
            if(Yii::$app->request->get('estrutura') != ''){
                $filtro['estrutura'] = Yii::$app->request->get('estrutura');
            }
            if(Yii::$app->request->get('ligantes') != ''){
                $filtro['ligantes'] = Yii::$app->request->get('ligantes');
            }

            $resultado =  ProteinaDAO::listarPag($start, $count, $filtro['nome'], $filtro['estrutura'], $filtro['ligantes']);
            $proteinas = $resultado['lista'];
            $filtro['pags'] = $resultado['pags'];
        }

        return $this->render("Busca", ["filtro"=>$filtro, "proteinas"=>$proteinas, "model"=>$model]);
    }

    public function actionRemover()
    {
        $proteina = Yii::$app->request->get('proteina');

        if(isset($proteina) && $proteina > 0){
            $p = ProteinaDAO::findIdentity($proteina);
            if($p->remover()){
                Yii::$app->getSession()->setFlash('msg', "Proteína ".$p->nome." removida.");
            }else{
                Yii::$app->getSession()->setFlash('msg', "Erro ao tentar remover proteína. A proteína está vinculada a outras operações.");
            }
        }
        return $this->redirect(['proteina/lista']);
    }

    public function actionAdicionar()
    {
        $model = new ProteinaForm();

        if ($model->load(Yii::$app->request->post())) {
            $pr = new ProteinaDAO();
            if($pr->adicionar($model->nome, $model->dados)){
                Yii::$app->getSession()->setFlash('msg', "Proteína ".$pr->nome." adicionada.");
                return $this->redirect(['proteina/lista']);
            }
        }

        return $this->render('Proteina', ['model' => $model]);
    }

    public function actionVisualizarEstrutura(){
        $componente = Yii::$app->request->get('componente');
        $estrutura = Yii::$app->request->get('estrutura');
        if(isset($componente) && $componente > 0 && isset($estrutura) && $estrutura > 0){
            $dao = new ProteinaDAO();
            $e = $dao->findEstrutura($componente, $estrutura);
            return $this->render('Visualizar', ['estrutura' => $e]);
        }
        Yii::$app->getSession()->setFlash('msg', "Proteína não encontrada.");
        return $this->redirect(['proteina/busca']);
    }

}
