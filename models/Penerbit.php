<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penerbit".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telepon
 * @property string $email
 */
class Penerbit extends \yii\db\ActiveRecord
{

         /**
     * @inheritdoc
     * @return array untuk dropdown
     */
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }
    
     //untuk menampilkan di buku sebagai nama
     public static function getPenerbit()
    {
        return $this->hasOne(Penerbit::className(), ['id' => 'id_penerbit']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penerbit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alamat'], 'string'],
            [['nama', 'telepon'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 2555],
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
        ];
    }

    //Untuk menampilkan jumlah buku yg berkaitan dgn form view masing-masing
     public function getJumlahBuku()
    {
        return Buku::find()
        ->andwhere(['id_penerbit' => $this->id])
        ->orderBy(['nama' => SORT_ASC])
        -> count();
    }

     //Untuk menampilkan data buku yg berkaitan dengan form view masing-masing
    public function findAllBuku() {
        return Buku::find()->andwhere(['id_penerbit' => $this->id])
        ->orderBy(['nama' => SORT_ASC])
        ->all();

    }
}
