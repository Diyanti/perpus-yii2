<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buku".
 *
 * @property int $id
 * @property string $nama
 * @property string $tahun_terbit
 * @property int $id_penulis
 * @property int $id_penerbit
 * @property int $id_kategori
 * @property string $sinopsis
 * @property string $sampul
 * @property string $berkas
 */
class buku extends \yii\db\ActiveRecord
{

      /**
     * @inheritdoc
     * @return array untuk dropdown
     */
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }

    
       //untuk menampilkan di tabel buku sebagai nama
    //  public static function getPenulis()
    // {
    //     return $this->hasOne(Penulis::class, ['id' => 'id_penulis']);
    // }

    // public static function getPenerbit()
    // {
    //     return $this->hasOne(Penerbit::className(), ['id' => 'id_penerbit']);
    // }

    // public static function getKategori()
    // {
    //     return $this->hasOne(Kategori::className(), ['id' => 'id_kategori']);
    // }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buku';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['tahun_terbit'], 'safe'],
            [['id_penulis', 'id_penerbit', 'id_kategori'], 'integer'],
            [['sinopsis'], 'string'],
            [['nama', 'sampul', 'berkas'], 'string', 'max' => 255],
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
            'tahun_terbit' => 'Tahun Terbit',
            'id_penulis' => 'Penulis',
            'id_penerbit' => 'Penerbit',
            'id_kategori' => 'Kategori',
            'sinopsis' => 'Sinopsis',
            'sampul' => 'Sampul',
            'berkas' => 'Berkas',
        ];
    }

    // public static function halo()

    // {
    //     return "Selamat Datang";
    // }

    //  public static function halolagi()
    
    // {
    //     return "Selamat Datang lagi";
    // }

    //  public function helo()
    
    // {
    //     return "Selamat Datang lagi 2";
    // }

    //relasi saat tabel penulis di panggil di modul buku

    public function getPenulis()
    {
        $model = Penulis::findOne($this->id_penulis);
        if ($model !== null) {
            return $model->nama;
        } else{
            return null;
        }

    }

    //relasi

    public function getPenerbit()
    {
        $model = Penerbit::findOne($this->id_penerbit);
        if ($model !== null) {
            return $model->nama;
        } else{
            return null;
        }

    }

    //relasi

    public function getKategori()
    {
        $model = Kategori::findOne($this->id_kategori);
        if ($model !== null) {
            return $model->nama;
        } else{
            return null;
        }

    }

     public static function getGrafikList()
    {
        $data = [];
        foreach (static::find()->all() as $buku) {
            $data[] = [StringHelper::truncate($buku->nama, 20), (int) $kabkota->getManyBuku()->count()];
        }
        return $data;
    }

    public static function getCount()
    {
        return static::find()->count();
    }


    }


