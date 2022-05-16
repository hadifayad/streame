<?php

use app\models\UsersSearch;
use richardfan\widget\JSRegister;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchModel UsersSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?php
//        echo        Html::a(Yii::t('app', 'Create Users'), ['create'], ['class' => 'btn btn-success'])
        ?>


    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'fullname',
            'password:ntext',
            'username',
//            'role',
            //'token',
            'link_facebook',
            'link_youtube',
            'link_instagram',
            'link_tiktok',
            //'profile_picture',
            ['attribute' => 'is approved',
                'value' => function ($data) {
                    if ($data['is_approved'] == '1') {
                        return Html::checkbox('is_approved', 1, ['class' => 'ddd', 'id' => $data->id,]);
                    } else {
                        return Html::checkbox('is_approved', 0, ['class' => 'ddd', 'id' => $data->id,]);
                    }
                }
                , 'format' => 'raw'
            ],
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>

//<?php
//JSRegister::begin([
//    'id' => '1',
//    'position' => static::POS_END
//]);
//?>

<script>

    $(".ddd").click(function () {
        var id = this.getAttribute("id");
        var is_approved = $(this).prop('checked');
        var is_approve_new_value;


        console.log(is_approved)
        console.log(is_approved || is_approved == true || is_approved == "true" || is_approved == 1);

        if (is_approved || is_approved == true || is_approved == "true" || is_approved == 1) {
            is_approve_new_value = 1;
        } else {
            is_approve_new_value = 0;
        }



        $.ajax({
            url: '<?php echo Url::toRoute("/api/approve/approve") ?>',
            type: "POST",
            data: {
                'id': id,
                'is_approved': is_approve_new_value,
            },
            success: function (data) {
                console.log(data);
            }
        });

    });
</script>
<?php
//JSRegister::end();
?>
