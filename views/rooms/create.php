<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rooms */

$this->title = Yii::t('app', 'Add Post');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rooms'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rooms-create">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
