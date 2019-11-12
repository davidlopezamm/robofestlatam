<?php

namespace frontend\controllers;

use backend\models\Model;
use common\models\User;
use frontend\models\Categoria;
use frontend\models\CompetenciaHasCategoria;
use frontend\models\EquipoHasCategoria;
use frontend\models\EquipoHasCompetenciaHasCategoria;
use frontend\models\Integrante;
use frontend\models\IntegranteHasCompetenciaHasCategoriaSearch;
use frontend\models\IntegranteSearch;
use frontend\models\UserHasCategoria;
use frontend\models\UserHasCategoriaSearch;
use Yii;
use frontend\models\Equipo;
use frontend\models\EquipoSearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\rbac\filters\AccessControl;

/**
 * EquipoController implements the CRUD actions for Equipo model.
 */
class EquipoController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'view', 'val-edad', 'val-correo'],
                        'allow' => true,
                        'roles' => ['Administrador', 'Mentor'],
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
     * Lists all Equipo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EquipoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel2 = new UserHasCategoriaSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);

        if (array_key_exists('Mentor', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
            $dataProvider2->query->andFilterWhere(['=', 'user_id', Yii::$app->user->id])->all();
            $dataProvider->query->andFilterWhere(['=', 'user_id', Yii::$app->user->id])->all();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'searchModel2' => $searchModel2,
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Displays a single Equipo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new IntegranteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['=', 'equipo_id', $id])
            ->one();
        $c = \frontend\models\EquipoHasCategoria::find()->andFilterWhere(['=', 'equipo_id', $id])->one();
        $edad_min = $c->categoria->edad_min;
        $edad_max = $c->categoria->edad_max;

        $connection = Yii::$app->getDb();

        $fullDatas = $connection->createCommand('SELECT * FROM `integrante_has_competencia_has_categoria` `ic` INNER JOIN `integrante` `i` INNER JOIN `equipo` `e` WHERE `ic`.integrante_id = `i`.id AND `i`.equipo_id = `e`.id AND `e`.id = '.$id.' GROUP BY `ic`.`competencia_has_categoria_id`, `ic`.`rid`')->queryAll();
        $grid = [];
        foreach($fullDatas AS $i => $fullData){
//            print_r($fullData);

            $competencia = CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->competencia->nombre;

            $names = $connection->createCommand('SELECT `i`.nombre FROM `integrante_has_competencia_has_categoria` `ic` INNER JOIN `integrante` `i` INNER JOIN `equipo` `e` WHERE `ic`.integrante_id = `i`.id AND `i`.equipo_id = `e`.id AND `e`.id = '.$id.' AND `ic`.`competencia_has_categoria_id` = '.CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->id.' AND `ic`.`rid` = '.$fullData["rid"])->queryAll();
            $nombres = '';
            foreach ($names AS $i => $name){
                if ($i > 0) {
                    $nombres = $nombres.', '.$name['nombre'];
                }else{
                    $nombres = $nombres . $name['nombre'];
                }
            }
            $grid[] = ['competencia' => $competencia, 'integrantes' => $nombres, 'competencia_has_categoria_id' => CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->id, 'equipo_id' =>$id, 'rid' =>$fullData["rid"]];
        }

//        print_r($grid);

        $provider = new ArrayDataProvider([
            'allModels' => $grid,
            'pagination' => [
//                 'pageSize' => 100,
            ],
            'sort' => [
                'attributes' => ['competencia', 'integrantes'],
            ]
        ]);

        $searchModel2 = new IntegranteHasCompetenciaHasCategoriaSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, $id);
//        $dataProvider2->query->andFilterWhere(['=', 'id', 13])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'provider' => $provider,
            'equipo' => $id,
            'edad_min' => $edad_min,
            'edad_max' => $edad_max,
        ]);
    }

    /**
     * Creates a new Equipo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Equipo();
        $modelC = UserHasCategoria::find()
            ->andFilterWhere(['=', "user_id", Yii::$app->user->identity->getId()])->all();
        if ($modelC){
            $modelC = UserHasCategoria::find()
                ->andFilterWhere(['=', "user_id", Yii::$app->user->identity->getId()])
                ->andWhere("cantidad_actual < cantidad_maxima")->all();
            if ($modelC){
                $categoria = \yii\helpers\ArrayHelper::map($modelC,
                    'categoria_id', 'categoria.nombre');
//                print_r($categoria);
            }else {
                echo "Ya ha creado todos los equipos que compró, requiere comprar otro equipo para poder proseguir.";
                die;
            }
        }else{echo "Requiere comprar un equipo antes de poder proseguir."; die;}
        $modelIntegrantes = [New Integrante()];

        if ($model->load(Yii::$app->request->post())) {

            $modelIntegrantes = Model::createMultiple(Integrante::classname());
            Model::loadMultiple($modelIntegrantes, Yii::$app->request->post());



            if (array_key_exists('Mentor', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
                $model->user_id = Yii::$app->user->identity->getId();

                $usuarioTieneCategoria = UserHasCategoria::find()
                    ->andFilterWhere(['=','user_id', Yii::$app->user->identity->getId()])
                    ->andFilterWhere(['=','categoria_id', $_POST['Equipo']['cantidad_integrantes']])->one();
                $usuarioTieneCategoria->cantidad_actual = $usuarioTieneCategoria->cantidad_actual+1;


                    $modelETC = new EquipoHasCategoria();
                    $modelETC->categoria_id = $_POST['Equipo']['cantidad_integrantes'];
                    $modelETC->cantidad_actual = 0;
                    $modelETC->cantidad_maxima = 5;

                $user = User::findOne(['id' => Yii::$app->user->identity->getId()]);
                $user->quantity_teams = $user->quantity_teams + 1;
                $user->save();




            }
            $model->cantidad_integrantes = 0;

            $transaction = \Yii::$app->db->beginTransaction();
            try {
                // Seguimos con el Array
                if (!($model->save(false))) {
                    print_r($model->getErrors[]);
                    $transaction->rollBack();
                    die;
                }else{
                    $modelETC->equipo_id = $model->id;
                    $modelETC->save();
                    $usuarioTieneCategoria->save();

                    foreach ($modelIntegrantes as $modelIntegrante ) {
                        // Instrucciones de la orden
                        $modelIntegrante->equipo_id = $model->id;
                        $modelIntegrante->edad = date('Y-m-d', strtotime($modelIntegrante->edad ));
                        $modelIntegrante->save();

                        // Seguimos con el Array
                        if (!($modelIntegrante->save(false))) {
                            print_r($modelIntegrante->getErrors[]);
                            $transaction->rollBack();
                            die;
                            break;
                        }else{
                            $model->cantidad_integrantes +=1;
                            $model->save();
                        }
                    }
                }

                $transaction->commit();

                echo "<script>window.history.back();</script>";
            } catch (Exception $e) {
                $transaction->rollBack();
            }

            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'modelIntegrantes' => (empty($modelIntegrantes)) ? [new Integrante()] : $modelIntegrantes,
            'categoria' => $categoria,
        ]);
    }

    /**
     * Updates an existing Equipo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Equipo model.
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
     * Finds the Equipo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Equipo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Equipo::findOne($id)) !== null) {
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
    public function actionValEdad($edad, $categoria)
    {
        $edad = (date('Y-m-d', strtotime($edad)));
        list($Y,$m,$d) = explode("-",$edad);
        $edad = ( date("md") < $m.$d ? date("Y")-$Y-1 : date("2020")-$Y );
        $Mcategoria = Categoria::findOne($categoria);
        if ($edad >= $Mcategoria->edad_min && $edad <= $Mcategoria->edad_max){
            return true;
        }else{
            return false;
        }
    }
    public function actionValCorreo($correo)
    {

        $integrante = Integrante::find()->andFilterWhere(['=', 'correo', $correo])->all();
        $user = User::find()->andFilterWhere(['=', 'email', $correo])->all();
        if ($integrante || $user) {
            return true;
        }else{
            return false;
        }
    }
}
