<?php

use app\models\Buku;

/* @var $this yii\web\View */

$this->title = 'Perpustakaan';
?>


<div class="site-index">
       
    <?php
    $model = Buku::findOne(31);
    print $model->nama;
    print $model->sinopsis;
    print $model->tahun_terbit;

    // $model->nama = "ubah dari kode";
    // $model->save();
   
    ?>
    <?php 

    $listbuku = Buku::findAll(['53', '49', '52']); ?>

    <?php foreach ($listbuku as $Buku) { ?>
    <p><?= $buku->nama; ?> - <?= $buku->sinopsis;?> </p>
    <?php 
    $buku->id_kategori = 1;
    $buku->save();
    ?>
<?php } ?>


        <div class="row">
            <div class="col-lg-4">

            </div>
        </div>

    </div>
</div>
