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
            'nama',
            'tahun_terbit',

            [
            'attribute' => "id_penulis",
            'value' => function($data){
                return $data->getPenulis();
            }
        ],

             [
            'attribute' => "id_penerbit",
            'value' => function($data){
                return $data->getPenerbit();
            }
        ],

         [
            'attribute' => "id_kategori",
            'value' => function($data){
                 return $data->getKategori();

                //return $data->kategori->nama;

            }
        ],
            // 'sinopsis:ntext',
             [
              'attribute' => 'sampul',
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


