<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\multiselect\MultiSelect;

/* @var $this yii\web\View */
/* @var $model frontend\models\IntegranteHasCompetenciaHasCategoria */
/* @var $form yii\widgets\ActiveForm */
/* @var $cat int */
/* @var $ide int */
$int = \yii\helpers\ArrayHelper::map(\frontend\models\Integrante::find()
        ->andFilterWhere(['=', 'equipo_id', $ide])->all(),
        'id', 'nombre');

$comp = \yii\helpers\ArrayHelper::map(\frontend\models\CompetenciaHasCategoria::find()
    ->andFilterWhere(['=', 'categoria_id', $cat])->all(),
    'id', 'competencia.nombre');
/*$js = <<<JS

                                        jQuery.each( rem, function( i, val ) {
                                            $('option[value='+val+']', $('#integrantes')).remove();
                                            $('#integrantes').multiselect('rebuild');
                                            alert(val);
                                        });

    var element=$("#integrantes");
    $('#multi').on('click',function(e){
        //reset select2 values if previously selected 
        element.val(null).trigger('change');

        //get plugin options
        let dataSelect = eval(element.data('krajee-select2'));

        //get kartik-select2 options
        let krajeeOptions = element.data('data-s2-options');

        //add your options
        dataSelect.maximumSelectionLength=2;

        //apply select2 options and load select2 again
        $.when(element.select2(dataSelect)).done(initS2Loading("integrantes", krajeeOptions));
    });

    $('#single').on('click',function(e){
        element.val(null).trigger('change');
        let dataSelect = eval(element.data('krajee-select2'));
        let krajeeOptions = element.data('s2-options');
        dataSelect.multiple=false;
        $.when(element.select2(dataSelect)).done(initS2Loading("integrantes", krajeeOptions));
    });
JS;

$this->registerJs($js, \yii\web\View::POS_READY);*/
$js = <<<JS
                    var max = 2;
        $('#delete').on('click', function() {
//            $('#integrantes').empty();    
            $('option[value="53"]', $('#integrantes')).remove();
            $('#integrantes').multiselect('rebuild');
        });
        $('#add').on('click', function() {
//            $('#integrantes').empty();    
            $('#integrantes').append('<option value="53">Ariel</option>');
            $('#integrantes').multiselect('rebuild');
        });
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>
<?= Html::csrfMetaTags() ?>


<script>
    var expanded = false;

    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
    /*
        function showInfo(){
            if(($("#columns").val())){
                $.post("index.php?r=order/orderhistory&columns="'.'+($("#columns").val())+"&id="'.'+$(this).val(), function( data ){
                    $("#1").html(data);
                });
            }
        }
    */
</script>
<style>
    .multiselect {
        width: 100%;
    }

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 100%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    #checkboxes {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxes label {
        display: inline-block;
        margin: 2px;
        padding: 1px 5px;
    }

    #checkboxes label:hover {
        background-color: #1e90ff;
    }
</style>

<div class="integrante-has-competencia-has-categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'competencia_has_categoria_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => $comp,
                'options' => [
                    'placeholder' => Yii::t('app', 'Elige la competencia'),
                    'onchange' => '
                                    $("#save").attr("disabled", "disabled");
                                    var element=$("#integrantes");
                                    $(\'option\', $(\'#integrantes\')).each(function(element) {
                                        $(this).removeAttr(\'selected\').prop(\'selected\', false);
                                    });
                                    element.multiselect("refresh");
                                    $.post("index.php?r=integrante-has-competencia-has-categoria/val-comp&comp="'.'+$(this).val()+'.'"&ide="+'.$ide.', function( data ){
                                        var res = data.split("|");
                                        max = res[0]; 
                                        $(\'#integrantes\').empty();
                                        var ids = res[1].split(",");
                                        var names = res[2].split(",");
                                        jQuery.each( ids, function( i, val ) {
                                            $(\'#integrantes\').append(\'<option value=\'+val+\'>\'+names[i]+\'</option>\');
                                        });
                                        $(\'#integrantes\').multiselect(\'rebuild\');
                                    });
                                    ',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?php /*$form->field($model, 'integrante_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => $int,
                'options' => [
                    'placeholder' => Yii::t('app', 'Elige a los integrante'),
                    'multiple' => true,
                    'id' => 'integrantes',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
//            'maximumSelectionLength'=> 1,
                ],
                'showToggleAll' => false,
//        'enableClickableOptGroups' => true,
                //      'enableCollapsibleOptGroups' => true,
                'hideSearch' => false,

                'pluginEvents' => [
                    "change" => "function(){
                            if(!($(this).val().toString().includes(','))){
                                $(\"#save\").attr(\"disabled\", 'disabled');
                            }else{
                                $(\"#save\").attr(\"disabled\", false);
                            };
                        }",
                ],
            ]);;   */?>


            <label class="control-label" for="hibrids">Seleccione a sus Integrantes</label>
            <br>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#integrantes').multiselect({
                        enableClickableOptGroups: true,
                        enableCollapsibleOptGroups: true,
                        enableFiltering: true,
                        maxHeight: 300,
                        onChange: function(option, checked) {
                            // Get selected options.
                            var selectedOptions = $('#integrantes option:selected');
                            if (selectedOptions.length <= 1) {
                                $("#save").attr("disabled", 'disabled');
                            }else{
                                $("#save").attr("disabled", false);
                            }

                            if (selectedOptions.length >= max) {
                                // Disable all other checkboxes.
                                var nonSelectedOptions = $('#integrantes option').filter(function() {
                                    return !$(this).is(':selected');
                                });

                                nonSelectedOptions.each(function() {
                                    var input = $('input[value="' + $(this).val() + '"]');
                                    input.prop('disabled', true);
                                    input.parent('li').addClass('disabled');
                                });
                            }
                            else {
                                // Enable all checkboxes.
                                $('#integrantes option').each(function() {
                                    var input = $('input[value="' + $(this).val() + '"]');
                                    input.prop('disabled', false);
                                    input.parent('li').removeClass('disabled');
                                });
                            }
                        }
                    });
                });
            </script>

            <?php
            /* echo $form->field($model, 'Hybrid_idHybrid')->widget(MultiSelect::classname(), [
                    'data' => ArrayHelper::map(Hybrid::find()->all(), 'idHybrid', 'variety'),
                    "options" => ['multiple'=>"multiple"]
                ]
            );

            echo $form->field($model, 'Hybrid_idHybrid')->widget(\dosamigos\multiselect\MultiSelectListBox::classname(), [
                    'data' => ArrayHelper::map(Hybrid::find()->all(), 'idHybrid', 'variety'),
                    "options" => ['multiple'=>"multiple"]
                ]
            );*/
            ?>

            <!-- Build your select: -->

            <select id="integrantes" multiple="multiple" name="integrantes">
                <?php
                $hibrids = \frontend\models\Integrante::find()->andFilterWhere(['=', 'equipo_id' , $ide])->all();
                foreach ($hibrids AS $hibrid){
                    echo '<option value="'.$hibrid->id.'">'.$hibrid->nombre.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
<!--    <button id="delete" class="btn btn-danger" >Delete</button>
    <button id="add" class="btn btn-info" >Delete</button>-->
    <div class="form-group">
        <?= Html::Button(Yii::t('app', 'Save'),
                ['class' => 'btn btn-success', 'id' => 'save', 'disabled' => 'disabled',
//                    'onclick' => 'window.location.href = ("'.\yii\helpers\Url::toRoute('integrante-has-competencia-has-categoria/agregar&ide='.$ide.'&comp=').'"+$("#integrantehascompetenciahascategoria-competencia_has_categoria_id").val()+"&ints="+$("#integrantes").val());',
                    'onclick' => 'window.location.href = "index.php?r=integrante-has-competencia-has-categoria/agregar&ide='.$ide.'&comp="+$("#integrantehascompetenciahascategoria-competencia_has_categoria_id").val()+"&ints="+$("#integrantes").val();',
                ]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
