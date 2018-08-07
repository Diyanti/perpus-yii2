<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kategori */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Kategoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-view">

    <p style="float: right;">
        <?= Html::a('Sunting', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    <h3><?= Html::encode($this->title) ?></h3>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nama',
            [
                'label' => 'Jumlah Buku',
                'value' => $model->getJumlahBuku()
            ],
        ],
    ]) ?>

    
</div>

<div>&nbsp;</div>
<p>
<?= Html::a('Tambah Buku', ['buku/create', 'id_kategori' => $model->id], ['style' => 'background: #04b4ae; border:none; color:#fff; border-radius:25px; font-size:11px; padding: 13px 25px; margin-bottom:15px; text-align:center; font-weight: bold;']) ?>
</p>
<div>&nbsp;</div>
<table class="table" border="1px;">

    <tr>
        <td>No</td>
        <td>Nama Buku</td>
        <td>Opsi</td>
    </tr>
   <?php $no=1; foreach ($model->findAllBuku() as $buku) { ?>

    <tr>
        <td><?= $no?></td>
        <td><?= $buku->nama; ?></td>
        <td>
            <?= Html::a("Sunting",["buku/update","id"=>$buku->id], ['class' => 'btn btn-primary']); ?>&nbsp;
            <?= Html::a("Hapus",["buku/delete","id"=>$buku->id],['class' => 'btn btn-danger', 'data-method'=>'post','data_confirm'=>'yakin ingin di hapus?']); ?> &nbsp;
        </td>
    </tr>
 <?php } ?>
 </table>
