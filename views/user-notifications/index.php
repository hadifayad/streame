<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserNotificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'number_remaining',
            'number_remaining_for_all_users',
            'user_id',
            'product_name',
        ],
    ]); ?>


</div>
