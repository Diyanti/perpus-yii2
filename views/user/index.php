<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Anggota;
use app\models\Petugas;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'username',
            [
               'attribute' =>'username',
               'headerOptions' => ['style' => 'text-align:center;'],
           ],

            // 'password',
           [
               'attribute' =>'password',
               'headerOptions' => ['style' => 'text-align:center;'],
           ],
            // 'id_anggota',
            [
               'attribute' =>'id_anggota',
               'filter' => Anggota::getList(),
               'headerOptions' => ['style' => 'text-align:center;'],
               'value' => function($data){
                return @$data->anggota->nama;
               }
           ],

           [
               'attribute' =>'id_petugas',
               'filter' => Petugas::getList(),
               'headerOptions' => ['style' => 'text-align:center;'],
               'value' => function($data){
                return @$data->petugas->nama;
               }
           ],
            // 'id_petugas',
            //'id_user_role',
            //'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
