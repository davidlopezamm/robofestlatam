<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UserHasCategoria;
use frontend\models\UserHasCategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserHasCategoriaController implements the CRUD actions for UserHasCategoria model.
 */
class UserHasCategoriaController extends Controller
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
     * Lists all UserHasCategoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserHasCategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserHasCategoria model.
     * @param integer $id
     * @param integer $user_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $user_id, $categoria_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $user_id, $categoria_id),
        ]);
    }

    /**
     * Creates a new UserHasCategoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserHasCategoria();

        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->identity->getId();

            $tenia = UserHasCategoria::find()
                ->andFilterWhere(['=', "user_id", Yii::$app->user->identity->getId()])
                ->andFilterWhere(['=', "categoria_id", $model->categoria_id])->all();
            if ($tenia){
               foreach ($tenia AS $teni){
                   $teni->cantidad_maxima = $teni->cantidad_maxima + $model->cantidad_maxima;
                   $teni->save();
               }
            }else{
               $model->save();
            }
            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserHasCategoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $user_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $user_id, $categoria_id)
    {
        $model = $this->findModel($id, $user_id, $categoria_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'categoria_id' => $model->categoria_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserHasCategoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $user_id
     * @param integer $categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $user_id, $categoria_id)
    {
        $this->findModel($id, $user_id, $categoria_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserHasCategoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $user_id
     * @param integer $categoria_id
     * @return UserHasCategoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $user_id, $categoria_id)
    {
        if (($model = UserHasCategoria::findOne(['id' => $id, 'user_id' => $user_id, 'categoria_id' => $categoria_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
