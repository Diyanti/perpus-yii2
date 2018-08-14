<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "peminjaman".
 *
 * @property int $id
 * @property int $id_buku
 * @property int $id_anggota
 * @property string $tanggal_pinjam
 * @property string $tanggal_kembali
 */
class Peminjaman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peminjaman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_buku', 'id_anggota', 'tanggal_pinjam', 'tanggal_kembali'], 'required'],
            [['id_buku', 'id_anggota'], 'integer'],
            [['tanggal_pinjam', 'tanggal_kembali'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_buku' => 'Buku',
            'id_anggota' => 'Anggota',
            'tanggal_pinjam' => 'Tanggal Pinjam',
            'tanggal_kembali' => 'Tanggal Kembali',
        ];
    }

     //Untuk menampilkan jumlah buku yg berkaitan dgn form view masing-masing
    //  public function getJumlahBuku()
    // {
    //     return Buku::find()
    //     ->andwhere(['id_peminjaman' => $this->id])
    //     ->orderBy(['nama' => SORT_ASC])
    //     -> count();
    // }

        //relasi

    // public function getBuku()
    // {
    //     $model = Buku::findOne($this->id_buku);
    //     if ($model !== null) {
    //         return $model->nama;
    //     } else{
    //         return null;
    //     }

    // }

          //relasi
    // public function getAnggota()
    // {
    //     $model = Anggota::findOne($this->id_anggota);
    //     if ($model !== null) {
    //         return $model->nama;
    //     } else{
    //         return null;
    //     }

    // }

     //untuk menampilkan di tabel buku sebagai nama
    public function getBuku()
    {
        return $this->hasOne(Buku::className(), ['id' => 'id_buku']);
    }

    //untuk menampilkan di tabel buku sebagai nama
    public function getAnggota()
    {
        return $this->hasOne(Anggota::className(), ['id' => 'id_anggota']);
    }

}
