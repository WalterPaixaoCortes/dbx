<?php

namespace app\controllers;

use app\models\AgendamentoDAO;
use app\models\AgendamentoForm;
use app\models\ArtigoDAO;
use app\models\ArtigoForm;
use app\models\BuscarAgendamentoForm;
use app\models\BuscarProteinaForm;
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
use DateTime;

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
                        'actions' => ['index', 'lista',  'remover', 'adicionar', 'editar'],
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
        $model->inicio = DateTime::createFromFormat("d/m/Y", date("d/m/Y",time()));

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
                    return $this->redirect(['agendamento/lista']);
                }
                Yii::$app->getSession()->setFlash('msg', "Erro ao tentar salvar o agendamento.");
            }
        }
        $componentes = ComponenteColetaDAO::listAll();
        return $this->render("Agendamento", ['model'=>$model, 'componentes'=>$componentes, 'selecionados'=>[]]);
    }

    public function actionEditar()
    {
        $model = new AgendamentoForm();
        $selecionados = [];

        if ($model->load(Yii::$app->request->post())) {
            $selecionados = str_getcsv(Yii::$app->request->post('ordem'), ";");
            $model->validacao();
            if(!$model->hasErrors()) {
                $agendamento = AgendamentoDAO::findIdentity($model->id);
                $agendamento->componentes = $selecionados;
                $agendamento->nome = $model->nome;
                $agendamento->comentario = $model->comentario;
                $agendamento->inicio = $model->data;
                $agendamento->intervalo = $model->intervalo;
                $agendamento->id = $model->id;
                if($agendamento->atualizar()){
                    Yii::$app->getSession()->setFlash('msg', "Agendamento salvo!");
                    return $this->redirect(['agendamento/lista']);
                }
                Yii::$app->getSession()->setFlash('msg', "Erro ao tentar salvar o agendamento.");
            }
        }else{
            if(Yii::$app->request->get('agendamento') != ''){
                $agendamento = AgendamentoDAO::findIdentity(Yii::$app->request->get('agendamento'));
                $agendamento->carregarComponentes();
                $selecionados = $agendamento->componentes;
                $model->nome = $agendamento->nome;
                $model->comentario = $agendamento->comentario;
                $model->intervalo  = $agendamento->intervalo;
                $model->inicio = date("m/d/Y",strtotime($agendamento->inicio));
//                die(var_dump($model->inicio));
                $model->hora  = date("H",strtotime($agendamento->inicio));
                $model->minuto  = date("i",strtotime($agendamento->inicio));
                $model->id = $agendamento->id;
            }
        }
        $componentes = ComponenteColetaDAO::listAll();
        return $this->render("Agendamento", ['model'=>$model, 'componentes'=>$componentes, 'selecionados'=>$selecionados]);
    }

    public function actionLista()
    {
        $model = new BuscarAgendamentoForm();
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
            $resultado =  AgendamentoDAO::listPag($start, $count, $filtro['nome']);
            $proteinas = $resultado['lista'];
            $filtro['pags'] = $resultado['pags'];
        }else{
            if(Yii::$app->request->get('nome') != ''){
                $filtro['nome'] = Yii::$app->request->get('nome');
            }
            $resultado =  AgendamentoDAO::listPag($start, $count, $filtro['nome']);
            $proteinas = $resultado['lista'];
            $filtro['pags'] = $resultado['pags'];
        }

        return $this->render("Lista", ["filtro"=>$filtro, "model"=>$model, 'agendamentos'=>$resultado['lista']]);
    }

    public function actionRemover()
    {
        $agendamento = Yii::$app->request->get('agendamento');

        if(isset($agendamento) && $agendamento > 0){
            $a = AgendamentoDAO::findIdentity($agendamento);
            if($a->remover()){
                Yii::$app->getSession()->setFlash('msg', "Agendamento ".$a->nome." removido.");
            }else{
                Yii::$app->getSession()->setFlash('msg', "Erro ao tentar remover o agendamento.");
            }
        }
        return $this->redirect(['agendamento/lista']);
    }
}
