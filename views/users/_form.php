<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->textInput() ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link_facebook')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link_youtube')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link_instagram')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link_tiktok')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profile_picture')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_approved')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
