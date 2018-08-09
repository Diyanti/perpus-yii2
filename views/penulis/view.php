<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Penulis */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Penulis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penulis-view">

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
            'nama',
            'alamat:ntext',
            'telepon',
            'email:email',
          [
                'label' => 'Jumlah Buku',
                'value' => $model->getJumlahBuku()
            ],
        ],
    ]) ?>
</div>
<div>&nbsp;</div>
<p>
<?= Html::a('Tambah Buku', ['buku/create', 'id_penulis' => $model->id], ['class' => 'btn btn-info']) ?>
</p>
<div>&nbsp;</div>
<table class="table">

    <tr>
        <td>No.</td>
        <td>Nama Buku</td>
        <td>$nbsp;</td>
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


