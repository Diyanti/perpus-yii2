<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Anggota;
use app\models\Petugas;


/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?php //if ($model->id_penerbit == null) { ?>
    <?= $form->field($model, 'id_anggota')->widget(Select2::classname(), [
            'data' =>  Anggota::getList(),
            'options' => [
              'placeholder' => '- Pilih Anggota -',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    <?php //}?>

     <?php //if ($model->id_penerbit == null) { ?>
    <?= $form->field($model, 'id_petugas')->widget(Select2::classname(), [
            'data' =>  Petugas::getList(),
            'options' => [
              'placeholder' => '- Pilih Petugas -',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    <?php //}?>

   <?= $form->field($model, 'id_user_role')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
