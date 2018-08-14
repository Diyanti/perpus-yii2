<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Buku;
use app\models\Peminjaman;
use app\models\Anggota;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeminjamanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Peminjamen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peminjaman-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Peminjaman', ['create'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Export word', ['peminjaman/data-pem'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
           // 'id_buku',
        //      [
        //     'attribute' => "id_buku",
        //     'value' => function($data){
        //         return $data->getBuku();
        //     }
        // ],
            [
               'attribute' =>'id_buku',
               'filter' => Buku::getList(),
               'headerOptions' => ['style' => 'text-align:center;'],
               'value' => function($data){
                return @$data->buku->nama;
               }
           ],
           // 'id_anggota',
        // [
        //     'attribute' => "id_anggota",
        //     'value' => function($data){
        //         return $data->getAnggota();
        //     }
        // ],
           [
               'attribute' =>'id_anggota',
               'filter' => Anggota::getList(),
               'headerOptions' => ['style' => 'text-align:center;'],
               'value' => function($data){
                return @$data->anggota->nama;
               }
           ],
            // 'tanggal_pinjam',
           [
               'attribute' =>'tanggal_pinjam',
               'headerOptions' => ['style' => 'text-align:center;'],
           ],
            // 'tanggal_kembali',
           [
               'attribute' =>'tanggal_kembali',
               'headerOptions' => ['style' => 'text-align:center;'],
           ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
