<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fullname') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'link_facebook') ?>

    <?php // echo $form->field($model, 'link_youtube') ?>

    <?php // echo $form->field($model, 'link_instagram') ?>

    <?php // echo $form->field($model, 'link_tiktok') ?>

    <?php // echo $form->field($model, 'profile_picture') ?>

    <?php // echo $form->field($model, 'is_approved') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
