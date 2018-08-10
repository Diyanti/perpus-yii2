<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kategori".
 *
 * @property int $id
 * @property string $nama
 */
class Kategori extends \yii\db\ActiveRecord
{

    //Untuk mengambil data yg ada di tabel ini sendiri dan di tampilkan di form tambah buku di bagian create buku
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
        return 'kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255],
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
        ];

    }

    //Untuk menampilkan data buku yg berkaitan dengan form view masing-masing
    public function findAllBuku() 
    {
        return Buku::find()
        ->andwhere(['id_kategori' => $this->id])
        ->orderBy(['nama' => SORT_ASC])
        ->all();

    }

    //Untuk menampilkan jumlah buku yg berkaitan dgn form view masing-masing
     public function getJumlahBuku()
    {
        return Buku::find()
        ->andwhere(['id_kategori' => $this->id])
        ->orderBy(['nama' => SORT_ASC])
        -> count();
    }

     public static function getKategoriCount()
    {
        return static::find()->count();
    }

     public function getManyBuku()
    {
        return $this->hasMany(Buku::class, ['id_kategori' => 'id']);
    }

    public static function getGrafikList()
    {
        $data = [];
        foreach (static::find()->all() as $kategori) {
            $data[] = [$kategori->nama, (int) $kategori->getManyBuku()->count()];
        }
        return $data;
    }

    

    }

   
