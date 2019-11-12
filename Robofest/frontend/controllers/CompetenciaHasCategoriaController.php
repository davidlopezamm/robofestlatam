<?php

namespace frontend\controllers;

use Yii;
use frontend\models\CompetenciaHasCategoria;
use frontend\models\CompetenciaHasCategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\rbac\filters\AccessControl;

/**
 * CompetenciaHasCategoriaController implements the CRUD actions for CompetenciaHasCategoria model.
 */
class CompetenciaHasCategoriaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'create', 'update', 'view'],
                        'allow' => true,
                        'roles' => ['Administrador'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CompetenciaHasCategoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompetenciaHasCategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompetenciaHasCategoria model.
     * @param integer $id
     * @param integer $Competencia_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $Competencia_id, $categoria_id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id, $Competencia_id, $categoria_id),
        ]);
    }

    /**
     * Creates a new CompetenciaHasCategoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompetenciaHasCategoria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CompetenciaHasCategoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $Competencia_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $Competencia_id, $categoria_id)
    {
        $model = $this->findModel($id, $Competencia_id, $categoria_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CompetenciaHasCategoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $Competencia_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $Competencia_id, $categoria_id)
    {
        $this->findModel($id, $Competencia_id, $categoria_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CompetenciaHasCategoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $Competencia_id
     * @param integer $categoria_id
     * @return CompetenciaHasCategoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $Competencia_id, $categoria_id)
    {
        if (($model = CompetenciaHasCategoria::findOne(['id' => $id, 'Competencia_id' => $Competencia_id, 'categoria_id' => $categoria_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
