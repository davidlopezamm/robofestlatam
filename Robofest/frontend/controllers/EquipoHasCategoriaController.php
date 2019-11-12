<?php

namespace frontend\controllers;

use Yii;
use frontend\models\EquipoHasCategoria;
use frontend\models\EquipoHasCategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EquipoHasCategoriaController implements the CRUD actions for EquipoHasCategoria model.
 */
class EquipoHasCategoriaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EquipoHasCategoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EquipoHasCategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EquipoHasCategoria model.
     * @param integer $id
     * @param integer $equipo_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $equipo_id, $categoria_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $equipo_id, $categoria_id),
        ]);
    }

    /**
     * Creates a new EquipoHasCategoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EquipoHasCategoria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'equipo_id' => $model->equipo_id, 'categoria_id' => $model->categoria_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EquipoHasCategoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $equipo_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $equipo_id, $categoria_id)
    {
        $model = $this->findModel($id, $equipo_id, $categoria_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'equipo_id' => $model->equipo_id, 'categoria_id' => $model->categoria_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EquipoHasCategoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $equipo_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $equipo_id, $categoria_id)
    {
        $this->findModel($id, $equipo_id, $categoria_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EquipoHasCategoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $equipo_id
     * @param integer $categoria_id
     * @return EquipoHasCategoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $equipo_id, $categoria_id)
    {
        if (($model = EquipoHasCategoria::findOne(['id' => $id, 'equipo_id' => $equipo_id, 'categoria_id' => $categoria_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
