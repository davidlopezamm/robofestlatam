<?php

use backend\models\Hybrid;
use frontend\models\Competencia;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Equipo */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelIntegrantes yii\widgets\ActiveForm */
?>

<div class="equipo-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'cantidad_integrantes')->widget(\kartik\select2\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\frontend\models\UserHasCategoria::find()
                    ->andFilterWhere(['=', 'user_id', Yii::$app->user->identity->getId()])
                    ->andWhere('cantidad_actual < cantidad_maxima')->all(),
                    'categoria_id', 'categoria.nombre'),
                'options' => [
                    'placeholder' => Yii::t('app', 'Elige la categoria'),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Categoria'); ?>
        </div>
    </div>

    <?php
    if (array_key_exists('Administrador', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
        echo $form->field($model, 'user_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->all(),
                'id', 'username'),
            'options' => [
                'placeholder' => Yii::t('app', 'Elige al usuario'),
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    }
    ?>
    <?php
//    echo $modelsorder[0];
    ?>
    <?php
        if ($model->isNewRecord) {
    ?>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Crear Integrantes</h4></div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 5, // the maximum times, an element can be cloned (default 999)
                    'min' => 2, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' =>  $modelIntegrantes[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'nombre',
                        'correo',
                        'edad',
                        'genero',
                    ],
                ]); ?>
                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelIntegrantes as $i => $modelorder): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Integrante</h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (! $modelorder->isNewRecord) {
                                    echo Html::activeHiddenInput($modelorder, "[{$i}]id");
                                }
                                ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <?= $form->field($modelorder, "[{$i}]nombre")->textInput(["maxlength" => true]) ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($modelorder, "[{$i}]correo")->textInput(["maxlength" => true,
                                            'onchange' => '
                                            var element = $(this);
                                                $.post("index.php?r=equipo/val-correo&correo="'.'+$(this).val(), function( data ){
                                                    if(data){
                                                        alert("Correo seleccionado por otro usuario");
                                                        element.val("");
                                                    }
                                                    });
                                                ',]) ?>
                                    </div>
                                    <div class="col-sm-3">

                                        <?php echo $form->field($modelorder, "[{$i}]edad")->widget(\yii\jui\DatePicker::classname(), [
                                            //'language' => 'ru',
                                            'dateFormat' => "dd-M-yyyy",
                                            'language' => 'es',
                                            'options' => [
                                                'class' => 'form-control picker edad',
                                                'placeholder' => Yii::t('app', 'Fecha de nacimiento'),
                                                'onchange' => '
                                            var element = $(this);
                                                if($.isNumeric($("#equipo-cantidad_integrantes").val())){
                                                    $.post("index.php?r=equipo/val-edad&edad="'.'+$(this).val()+"&categoria="'.'+$("#equipo-cantidad_integrantes").val(), function( data ){
                                                        if(data != 1){
                                                            alert("Edad no valida para la categoría escogida.");
                                                            element.val("");
                                                        }
                                                    });
                                                }else{
                                                    alert("Debe de seleccionar una categoría y volver a poner la edad.");
                                                    element.val("");
                                                }',

                                            ],
                                            'clientOptions' => [

                                                'changeMonth' => true,

                                                'changeYear' => true,
                                            ],
                                        ]);
                                        /*$form->field($modelorder, "[{$i}]edad")->widget(
                                            \dosamigos\datepicker\DatePicker::className(), [
                                            // inline too, not bad
//        'inline' => true,
                                            'language' => 'es_ES',
                                            'value' => 'dd-mm-yyyy',
                                            // modify template for custom rendering
//        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                            'clientOptions' => [
                                                'autoclose' => true,
                                                'format' => 'dd-mm-yyyy',
                                                'class' => 'form-control edad',
                                            ],
                                            'options' => [
                                                'placeholder' => Yii::t('app', 'Choose Order'),
                                                'onchange' => '
                                            var element = $(this);
                                                if($.isNumeric($("#equipo-cantidad_integrantes").val())){
                                                    $.post("index.php?r=equipo/val-edad&edad="'.'+$(this).val()+"&categoria="'.'+$("#equipo-cantidad_integrantes").val(), function( data ){
                                                        if(data != 1){
                                                            alert("Edad no valida para la categorí escogida .");
                                                            element.val("");
                                                        }
                                                    });
                                                }else{
                                                    alert("Debe de seleccionar una categoría y volver a poner la edad.");
                                                    element.val("");
                                                }',
                                            ],
                                        ]); */ ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?=
                                        $form->field($modelorder, "[{$i}]genero")->widget(\kartik\select2\Select2::classname(), [
                                            'data' => ['Hombre' => 'Hombre', 'Mujer' => 'Mujer', 'Otro' => 'Otro'],
                                            'options' => [
                                                'placeholder' => Yii::t('app', 'Selecciona tú género'),
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>
            <p>
                <input type="checkbox" required id="queue-order" value="1"> Acepta nuestros términos y condiciones.
            </p>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success', 'id' => 'save']) ?>
        <p id="message">Necesitas tener al menos 2 integrantes para crear tu equipo.</p>
    </div>
    <?php
        }else{
          ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php
        }
     ?>
    <?php ActiveForm::end(); ?>


    <script>
        $("#save").attr("disabled", "disabled");
        $(".add-item").click(function(){
            $("#save").attr("disabled", false);
            $("#message").attr("hidden", true);
        });

        $(function () {
            $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
                $( ".picker" ).each(function() {
                    $( this ).datepicker({
                        dateFormat : 'dd-mm-yy',
                        language : 'en',
                        changeMonth: true,
                        changeYear: true
                    });
                });
            });
        });

    </script>
</div>