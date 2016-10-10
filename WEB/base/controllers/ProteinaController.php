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

        if(Yii::$app->request->get('pag') != null && Yii::$app->request->get('pag') != ''){
            $filtro['pag'] = Yii::$app->request->get('pag');
            $start = ($filtro['pag']-1)*$count;
        }

        if ($model->load(Yii::$app->request->post())) {
            $filtro['nome'] = $model->nome;
            $proteinas = ProteinaDAO::listPag($start, $count, $model->nome);
            $filtro['pags'] = ProteinaDAO::countPags($start, $count, $model->nome);
        }else{
            if(Yii::$app->request->get('nome') != ''){
                $filtro['nome'] = Yii::$app->request->get('nome');
            }
            $proteinas = ProteinaDAO::listPag($start, $count, $filtro['nome']);
            $filtro['pags'] = ProteinaDAO::countPags($start, $count, $filtro['nome']);
        }

        return $this->render("Lista", ["filtro"=>$filtro, "proteinas"=>$proteinas, "model"=>$model]);
    }

    public function actionRemover()
    {
        $proteina = Yii::$app->request->get('proteina');

        if(isset($proteina) && $proteina > 0){
            $p = ProteinaDAO::findIdentity($proteina);
            if($p->remover()){
                \Yii::$app->getSession()->setFlash('msg', "Proteina ".$p->nome." removida.");
            }else{
                \Yii::$app->getSession()->setFlash('msg', "Erro ao tentar remover proteina. A proteina está vinculada a outras operações.");
            }
        }
        return $this->redirect(['proteina/lista']);
    }



    public function actionAdicionar()
    {
        $model = new ProteinaForm();

        if ($model->load(Yii::$app->request->post())) {
            $pr = new ProteinaDAO();
            if($pr->adicionar($model->nome, $model->estrutura, $model->dados)){
                \Yii::$app->getSession()->setFlash('msg', "Proteina ".$pr->nome." adicionada.");
                return $this->redirect(['proteina/lista']);
            }
        }

        return $this->render('Proteina', ['model' => $model]);
    }


    public function actionEditar()
    {
        $proteina = Yii::$app->request->get('proteina');
        $model = new ProteinaForm();
        if ($model->load(Yii::$app->request->post())) {
            $p = ProteinaDAO::findIdentity($model->id);
            $p->nome = $model->nome;
            $p->estrutura = $model->estrutura;
            $p->dados = $model->dados;
            if($p->save()){
                \Yii::$app->getSession()->setFlash('msg', "Salvo!");
            }else{
                \Yii::$app->getSession()->setFlash('msg', "Erro ao salvar!");
            }
        }elseif(isset($proteina) && $proteina > 0){
            $p = ProteinaDAO::findIdentity($proteina);
            $model->nome = $p->nome;
            $model->estrutura = $p->estrutura;
            $model->dados = $p->dados;
            $model->id = $p->id;
        }

        return $this->render('Proteina', ['model' => $model]);
    }

    public function actionVisualizar(){
        $proteina = Yii::$app->request->get('proteina');
        if(isset($proteina) && $proteina > 0){
            $p = ProteinaDAO::findIdentity($proteina);
            return $this->render('visualizar', ['proteina' => $p]);
        }
        \Yii::$app->getSession()->setFlash('msg', "Proteína não encontrada.");
        return $this->redirect(['proteina/lista']);
    }

}
