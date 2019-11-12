<?php

namespace frontend\controllers;

use frontend\models\Equipo;
use Yii;
use frontend\models\Integrante;
use frontend\models\IntegranteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IntegranteController implements the CRUD actions for Integrante model.
 */
class IntegranteController extends Controller
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
     * Lists all Integrante models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IntegranteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Integrante model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Integrante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ide, $edad_min = 0, $edad_max = 99)
    {
        $equipo = Equipo::findOne($ide);
        if ($equipo->cantidad_integrantes <5) {
            $model = new Integrante();

            if ($model->load(Yii::$app->request->post())) {
                $model->equipo_id = $ide;
                $model->edad = date('Y-m-d', strtotime($model->edad ));
                if($model->save()) {
                    $equipos = Equipo::findOne($ide);
                    $equipos->cantidad_integrantes = $equipos->cantidad_integrantes + 1;
                    $equipos->save();
                }
                echo "<script>window.history.back();</script>";
                die;
            }

            return $this->renderAjax('create', [
                'model' => $model,
                'edad_min' => $edad_min,
                'edad_max' => $edad_max,
            ]);
        }else{
            echo "Solo puedes tener 5 integrantes por equipo.";
        }
    }

    /**
     * Updates an existing Integrante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $edad_min = 0, $edad_max = 99)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->edad = date('Y-m-d', strtotime($model->edad ));
            $model->save();
            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'edad_min' => $edad_min,
            'edad_max' => $edad_max,
        ]);
    }

    /**
     * Deletes an existing Integrante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Integrante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Integrante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Integrante::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    /**
     * Finds the Equipo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $edad $id
     * @param $categoria $id
     * @return boolean the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionValEdad($edad, $edad_min = 0, $edad_max = 99)
    {
        $edad = (date('Y-m-d', strtotime($edad)));
        list($Y,$m,$d) = explode("-",$edad);
        $edad = ( date("md") < $m.$d ? date("Y")-$Y-1 : date("2020")-$Y );
//        echo $edad;
  //          die;
        if ($edad >= $edad_min && $edad <= $edad_max){
            return true;
        }else{
            return false;
        }
    }
}
