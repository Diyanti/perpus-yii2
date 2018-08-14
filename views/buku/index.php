<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Penulis;
use app\models\Kategori;
use app\models\Buku;
use app\models\Penerbit;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BukuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buku';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buku-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div style="margin-top: 20px;"></div>
    <p>
        <?= Html::a('Tambah Buku', ['create'], ['style' => 'background: #04b4ae; border:none; color:#fff; border-radius:25px; font-size:11px; padding: 13px 25px; margin-bottom:15px; text-align:center; font-weight: bold;']) ?>
         
        <?= Html::a('Export word', ['buku/jadwal-pl'], ['class' => 'btn btn-success btn-flat']) ?>
     </p>
   
    <div>&nbsp;</div>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'nama',
            [
               'attribute' =>'nama',
               'headerOptions' => ['style' => 'text-align:center;'],
           ],
            // 'tahun_terbit',
           [
               'attribute' =>'tahun_terbit',
               'headerOptions' => ['style' => 'text-align:center;'],
           ],

             [
               'attribute' =>'id_penulis',
               'filter' => Penulis::getList(),
               'headerOptions' => ['style' => 'text-align:center;'],
               'value' => function($data){
                return @$data->penulis->nama;
               }
           ],

              [
               'attribute' =>'id_penerbit',
               'filter' => Penerbit::getList(),
               'headerOptions' => ['style' => 'text-align:center;'],
               'value' => function($data){
                return @$data->penerbit->nama;
               }
           ],

           [
               'attribute' =>'id_kategori',
               'filter' => Kategori::getList(),
               'headerOptions' => ['style' => 'text-align:center;'],
               'value' => function($data){
                return @$data->kategori->nama;
               }
           ],
           
            // 'sinopsis:ntext',
             [
              'attribute' => 'sampul',
              'headerOptions' => ['style' => 'text-align:center;'],
              'format' =>'raw',
              'value' => function ($model){
                if ($model->sampul != '') {
                    return Html::img('@web/upload/'. $model->sampul,['class'=>'img-responsive','style' => 'height:150px', 'align'=>'center']);
                }else{
                  return '<div align="center"><h1>No Image</h1></div>';
                }
              },
            ],
            
            // 'berkas',
            [
                'attribute' => 'berkas',
                'headerOptions' => ['style' => 'text-align:center;'],
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->berkas !='') {
                        return '<a href="' . Yii::$app->homeUrl . '/upload/' . $model->berkas . '"><div align="center"><button class="btn btn-success glyphicon glyphicon-download-alt"></button></div></a>';
                    } else {
                        return '<div align="center"><h1>No File</h1></div>';
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
</div>


