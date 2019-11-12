<?php

namespace frontend\controllers;

use frontend\models\CompetenciaHasCategoria;
use frontend\models\EquipoHasCategoria;
use frontend\models\Integrante;
use Yii;
use frontend\models\IntegranteHasCompetenciaHasCategoria;
use frontend\models\IntegranteHasCompetenciaHasCategoriaSearch;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IntegranteHasCompetenciaHasCategoriaController implements the CRUD actions for IntegranteHasCompetenciaHasCategoria model.
 */
class IntegranteHasCompetenciaHasCategoriaController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'view', 'val-comp', 'delete', 'agregar'],
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
     * Lists all IntegranteHasCompetenciaHasCategoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IntegranteHasCompetenciaHasCategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IntegranteHasCompetenciaHasCategoria model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $idc, $rid)
    {        $connection = Yii::$app->getDb();

        $fullDatas = $connection->createCommand('SELECT * FROM `integrante_has_competencia_has_categoria` `ic` INNER JOIN `integrante` `i` INNER JOIN `equipo` `e` WHERE `ic`.integrante_id = `i`.id AND `i`.equipo_id = `e`.id AND `e`.id = '.$id.' AND `ic`.`competencia_has_categoria_id` = '.$idc.' GROUP BY `ic`.`competencia_has_categoria_id`')->queryAll();

        foreach($fullDatas AS $i => $fullData){
//            print_r($fullData);

            $competencia = CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->competencia->nombre;

            $names = $connection->createCommand('SELECT `i`.nombre FROM `integrante_has_competencia_has_categoria` `ic` INNER JOIN `integrante` `i` INNER JOIN `equipo` `e` WHERE `ic`.integrante_id = `i`.id AND `i`.equipo_id = `e`.id AND `e`.id = '.$id.' AND `ic`.`competencia_has_categoria_id` = '.CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->id.' AND `ic`.`competencia_has_categoria_id` = '.$idc." AND `ic`.`rid` = ".$rid)->queryAll();
            $nombres = '';
            foreach ($names AS $i => $name){
                if ($i > 0) {
                    $nombres = $nombres.', '.$name['nombre'];
                }else{
                    $nombres = $nombres . $name['nombre'];
                }
            }
            $grid[] = ['competencia' => $competencia, 'integrantes' => $nombres, 'competencia_has_categoria_id' => CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->id, 'equipo_id' =>$id];
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
        return $this->renderAjax('view', [
            'provider' => $provider,
        ]);
    }

    /**
     * Creates a new IntegranteHasCompetenciaHasCategoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ide)
    {
        $model = new IntegranteHasCompetenciaHasCategoria();
        $cat = EquipoHasCategoria::find('equipo_id = '.$ide)->one()->categoria_id;
        $catN = EquipoHasCategoria::find('equipo_id = '.$ide)->one()->categoria->nombre;

        if ($model->load(Yii::$app->request->post())) {
            var_dump($_POST);
            die;
            $rid = rand();
            foreach ($model->integrante_id  As $i => $idi){
                $nmodel = new IntegranteHasCompetenciaHasCategoria();
                $nmodel->integrante_id=$idi;
                $nmodel->competencia_has_categoria_id=$model->competencia_has_categoria_id;
                $nmodel->rid = $rid;
                $nmodel->save();
            }

            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'cat' => $cat,
            'catN' => $catN,
            'ide' => $ide,
        ]);
    }

    /**
     * Updates an existing IntegranteHasCompetenciaHasCategoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $integrante_id
     * @param integer $competencia_has_categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $idc, $rid)
    {$connection = Yii::$app->getDb();

        $fullDatas = $connection->createCommand('SELECT * FROM `integrante_has_competencia_has_categoria` `ic` INNER JOIN `integrante` `i` INNER JOIN `equipo` `e` WHERE `ic`.integrante_id = `i`.id AND `i`.equipo_id = `e`.id AND `e`.id = '.$id.' AND `ic`.`competencia_has_categoria_id` = '.$idc.' GROUP BY `ic`.`competencia_has_categoria_id`')->queryAll();

        foreach($fullDatas AS $i => $fullData){
//            print_r($fullData);

            $competencia = CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->competencia->nombre;

            $names = $connection->createCommand('SELECT `i`.nombre,`i`.id  FROM `integrante_has_competencia_has_categoria` `ic` INNER JOIN `integrante` `i` INNER JOIN `equipo` `e` WHERE `ic`.integrante_id = `i`.id AND `i`.equipo_id = `e`.id AND `e`.id = '.$id.' AND `ic`.`competencia_has_categoria_id` = '.CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->id.' AND `ic`.`competencia_has_categoria_id` = '.$idc." AND `ic`.`rid` = ".$rid)->queryAll();
            $nombres = '';
            foreach ($names AS $i => $name){
                if ($i > 0) {
                    $nombres = $nombres.', '.$name['id'];
                }else{
                    $nombres = $nombres . $name['id'];
                }
            }
            $grid[] = ['competencia' => $competencia, 'integrantes' => $nombres, 'competencia_has_categoria_id' => CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->id, 'equipo_id' =>$id];
        }

        $model = new IntegranteHasCompetenciaHasCategoria();
        $model->competencia_has_categoria_id = CompetenciaHasCategoria::findOne($fullData["competencia_has_categoria_id"])->id;
        $model->integrante_id = explode(',', $nombres);
        $cat = EquipoHasCategoria::find('equipo_id = '.$id)->one()->categoria_id;
        $catN = EquipoHasCategoria::find('equipo_id = '.$id)->one()->categoria->nombre;

        if ($model->load(Yii::$app->request->post())) {
            $registrados = IntegranteHasCompetenciaHasCategoria::find()
                ->andFilterWhere(['=', 'rid', $rid])->all();

            foreach ($registrados AS $i => $registrado){
                $registrado->delete();
            }
            $rid2 = rand();
            foreach ($model->integrante_id  As $i => $idi){


                $nmodel = new IntegranteHasCompetenciaHasCategoria();
                $nmodel->integrante_id=$idi;
                $nmodel->competencia_has_categoria_id=$model->competencia_has_categoria_id;
                $nmodel->rid = $rid2;
                $nmodel->save();
            }

            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'cat' => $cat,
            'catN' => $catN,
            'id' => $id,
        ]);
    }

    /**
     * Deletes an existing IntegranteHasCompetenciaHasCategoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $integrante_id
     * @param integer $competencia_has_categoria_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($rid)
    {
        $registrados = IntegranteHasCompetenciaHasCategoria::find()
            ->andFilterWhere(['=', 'rid', $rid])->all();

        foreach ($registrados AS $i => $registrado){
            $registrado->delete();
        }
        echo "<script>window.history.back();</script>";
        die;
    }

    /**
     * Finds the IntegranteHasCompetenciaHasCategoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $integrante_id
     * @param integer $competencia_has_categoria_id
     * @return IntegranteHasCompetenciaHasCategoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $integrante_id, $competencia_has_categoria_id)
    {
        if (($model = IntegranteHasCompetenciaHasCategoria::findOne(['id' => $id, 'integrante_id' => $integrante_id, 'competencia_has_categoria_id' => $competencia_has_categoria_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionValComp($comp, $ide)
    {
        $competencia = CompetenciaHasCategoria::findOne($comp);
        $num_int = $competencia->competencia->num_integrantes;

        $registros = IntegranteHasCompetenciaHasCategoria::find()->joinWith('integrante')
            ->andFilterWhere(['=', 'competencia_has_categoria_id', $comp])
            ->andFilterWhere(['=', 'integrante.equipo_id', $ide])
            ->all();
        $integrantes = Integrante::find()->andFilterWhere(['=', 'equipo_id', $ide]);

        $ids = '';
        $names = '';

        if ($registros) {
            foreach ($registros AS $i => $registro) {
                if ($i == 0) {
//                    echo "Quita a: ".$registro->integrante->nombre;
                } else {
  //                  echo ', ' . $registro->integrante->nombre;
                }
                $integrantes = $integrantes->andWhere(['!=', 'id', $registro->integrante_id]);
            }
            echo "<br><br>";
        }
        $integrantes = $integrantes->all();

        $int = '[';
        foreach ($integrantes AS $i=>$integrante){
            if ($i == 0) {
            //    $int = $int."{label: '".$integrante->nombre."' , title: '".$integrante->nombre."' , value: '".$integrante->id."'}";
    //            echo "Deja a: ".$integrante->nombre;
                $ids = $ids.$integrante->id;
                $names = $names.$integrante->nombre;
            } else {
      //          echo ', ' . $integrante->nombre;
              //  $int = $int.",{label: '".$integrante->nombre."', title: '".$integrante->nombre."' , value: '".$integrante->id."'}";
                $ids = $ids.','.$integrante->id;
                $names = $names.', '.$integrante->nombre;
            }
//            $int = $int."<option value='".$integrante->id."'>".$integrante->nombre. "</option>";
        }

        $int = $int.']';
        return $num_int."|".$ids.'|'.$names;
    }

    public function actionAgregar($ide, $comp, $ints)
    {
        $rid = rand();
        $ints = explode(',', $ints);
        foreach ($ints  As $i => $idi){
            $nmodel = new IntegranteHasCompetenciaHasCategoria();
            $nmodel->integrante_id=$idi;
            $nmodel->competencia_has_categoria_id=$comp;
            $nmodel->rid = $rid;
            $nmodel->save();
        }

        echo "<script>window.history.back();</script>";
        die;
    }
}
