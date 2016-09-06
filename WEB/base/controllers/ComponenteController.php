<?php

namespace app\controllers;

use app\models\UploadBackgroundForm;
use app\models\UploadColetaForm;
use app\models\UploadForm;
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
                        'actions' => ['upload-background', 'upload-coleta'],
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

    public function actionUploadColeta()
    {
        $model = new UploadColetaForm();
        if ($model->load(Yii::$app->request->post())) {
            $this->upload($model);
        }
        return $this->render('Upload', [
            'model' => $model,
        ]);
    }

    public function actionUploadBackground()
    {
        $model = new UploadBackgroundForm();
        if ($model->load(Yii::$app->request->post())) {
            $this->upload($model);
        }
        return $this->render('Upload', [
            'model' => $model,
        ]);
    }

    private function upload($model)
    {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->salvar();
    }
}
