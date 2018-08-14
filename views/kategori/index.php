<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategori';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div style="margin-top: 20px;"></div>
    <p>
        <?= Html::a('Tambah Kategori', ['create'], ['style' => 'background: #04b4ae; border:none; color:#fff; border-radius:25px; font-size:11px; padding: 13px 25px; margin-bottom:15px; text-align:center; font-weight: bold;']) ?>

        <?= Html::a('Export PDF', ['kategori/jadwal-pl'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>
    <div>&nbsp;</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nama',
            [
                'label' => 'jumlah',
                'value' => function($model){
                    return $model -> getJumlahBuku();
                } 
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
