<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Peminjaman */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Peminjamen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peminjaman-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'id_buku',
            [
            'attribute' => "id_buku",
            'value' => function($data){
                return $data->getBuku();
            }
        ],
            // 'id_anggota',
        [
            'attribute' => "id_anggota",
            'value' => function($data){
                return $data->getAnggota();
            }
        ],
            'tanggal_pinjam',
            'tanggal_kembali',
        ],

         // [
         //        'label' => 'Jumlah Buku',
         //        'value' => $model->getJumlahBuku()
         //    ],

    ]) ?>

</div>
