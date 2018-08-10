<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anggota".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telepon
 * @property string $email
 * @property int $status_aktif
 */
class Anggota extends \yii\db\ActiveRecord
{
     /**
     * @inheritdoc
     * @return array untuk dropdown
     */
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anggota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['status_aktif'], 'integer'],
            [['nama', 'alamat'], 'string', 'max' => 255],
            [['telepon', 'email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon',
            'email' => 'Email',
            'status_aktif' => 'Status Aktif',
        ];
    }

    // //Untuk menampilkan jumlah buku yg berkaitan dgn form view masing-masing
    //  public function getJumlahPeminjaman()
    // {
    //     return Peminjaman::find()
    //     ->andwhere(['id_peminjaman' => $this->id])
    //     ->orderBy(['nama' => SORT_ASC])
    //     -> count();
    // }
    // //Untuk menampilkan data buku yg berkaitan dengan form view masing-masing
    // public function findAllPeminjaman() {
    //     return Peminjaman::find()->andwhere(['id_anggota' => $this->id])
    //     ->orderBy(['nama' => SORT_ASC])
    //     ->all();

    // }
   
}
