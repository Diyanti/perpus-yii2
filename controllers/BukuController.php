<?php

namespace app\controllers;

use Yii;
use app\models\Buku;
use app\models\BukuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ArrayHelper;
use PhpOffice\PhpWord\IOfactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;


/**
 * BukuController implements the CRUD actions for Buku model.
 */
class BukuController extends Controller
{
 //untuk merubah layout
    public $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Buku models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BukuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Buku model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Buku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_kategori=null,$id_penulis=null,$id_penerbit=null)
    {
        $model = new Buku();

        //Mengambil data (get) dari from setiap tabel untuk dimunculkan di (tambah buku) untuk otomatis ada di masing-masing

        $model->id_kategori = $id_kategori;
        $model->id_penulis = $id_penulis;
        $model->id_penerbit = $id_penerbit;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //ambil file berkas dan file sampul yg ada di form
            $sampul = UploadedFile::getInstance($model, 'sampul');
            $berkas = UploadedFile::getInstance($model, 'berkas');


            //merubah nama filenya
            $model->sampul = time() . '_' . $sampul->name;
            $model->berkas = time() . '_' . $berkas->name;

            //save data ke database
            $model->save(false);

            //lokasi untuk menyimpan file
            $sampul->saveAs(Yii::$app->basePath . '/web/upload/sampul/' . $model->sampul);
            $berkas->saveAs(Yii::$app->basePath . '/web/upload/berkas/' . $model->berkas);


            //Menuju ke view id yg data di buat
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Updates an existing Buku model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //Mengambil data lama di database
        $sampul_lama = $model->sampul;
        $berkas_lama = $model->berkas;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //Mengambil data baru di layout form
            $sampul = UploadedFile::getInstance($model, 'sampul');
            $berkas = UploadedFile::getInstance($model, 'berkas');

            //Jika ada data file yang dirubah maka data lama akan dihapus dan diganti dengan data baru yang sudah diambil 

            if ($sampul !== null) {
                unlink(Yii::$app->basePath . '/web/upload/sampul/' . $model->sampul_lama);
            } else {
                $model->sampul = $sampul_lama;
            }

            if ($berkas !== null) {
                unlink(Yii::$app->basePath . '/web/upload/berkas/' . $berkas_lama);
                $model->berkas = time() . '_' .$berkas->name;
            } else {
                $model->berkas = $berkas_lama;
            }

            //Simpan ke database
            $model->save(false);

            //Menuju ke view id yang datanya sudah dibuat
            return $this->redirect(['view', 'id' => $model->id]);
        }
            return $this->render('update', ['model' => $model,]);


        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Deletes an existing Buku model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Buku model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Buku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Buku::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Untuk Export Buku ke word
    public function actionJadwalPl()
    {
        $phpWord = new phpWord();
        $section = $phpWord->addSection(
            [
                'marginTop' => Converter::cmTotwip(1.80),
                'marginBottom' => Converter::cmTotwip(1.80),
                'marginLeft' => Converter::cmTotwip(1.2),
                'marginRight' => Converter::cmTotwip(1.6),
            ]
        );

        $fontStyle = [
            'underline' => 'dash',
            'bold' => true,
            'italic' => true,
        ];
        $paragraphCenter =[
        'alignment' =>'center',
        ];

        $headerStyle = [
            'bold' => true,
        ];

        $section->addText(
            'Jadwal pengadaan langsung',
            $headerStyle,
            $fontStyle,
            $paragraphCenter
        );

        $section->addText(
            'PENGADAAN JASA KONSULTASI',
            $headerStyle,
            $paragraphCenter
        );

        $section->addTextBreak(1);

        $judul = $section->addTextRun($paragraphCenter);

        $judul->addText('Keterangan dari ', $fontStyle);
        $judul->addText('Tabel ', ['italic' =>true]);
        $judul->addText('Buku ', ['bold' =>true]);

        $table = $section->addTable([
            'alignment' => 'center',
            'bgColor' => 6,
            'borderSize' => 6,
        ]);
        $table->addRow(null);
        $table->addCell(500)->addText('NO', $headerStyle, $paragraphCenter);
         $table->addCell(5000)->addText('Nama Buku', $headerStyle, $paragraphCenter);
          $table->addCell(5000)->addText('Tahun Terbit', $headerStyle, $paragraphCenter);
           $table->addCell(200)->addText('Penulis', $headerStyle, $paragraphCenter);
           $table->addCell(200)->addText('Penerbit', $headerStyle, $paragraphCenter);
           $table->addCell(200)->addText('Kategori', $headerStyle, $paragraphCenter);
            $table->addCell(200)->addText('Sinopsis', $headerStyle, $paragraphCenter);

    $semuaBuku = Buku::find()->all();
    $nomor = 1;
    foreach ($semuaBuku as $buku) {
    $table->addRow(null);
     $table->addCell(500)->addText($nomor++, null, $headerStyle, $paragraphCenter);
     $table->addCell(5000)->addText($buku->nama, null);
     $table->addCell(5000)->addText($buku->tahun_terbit, null, $paragraphCenter);
     $table->addCell(5000)->addText($buku->getPenulis(), null, $paragraphCenter);
     $table->addCell(5000)->addText($buku->getPenerbit(), null, $paragraphCenter);
      $table->addCell(5000)->addText($buku->getKategori(), null, $paragraphCenter);
      $table->addCell(5000)->addText($buku->sinopsis, null);

    }
      $filename = time() . 'Jadwal-PL.docx';
      $path = 'export/' . $filename;
      $xmlWriter = IOfactory::createWriter($phpWord, 'Word2007');
      $xmlWriter -> save($path);
      return $this -> redirect($path);
  }

    //untuk Export file ke Word
    public function actionExportWord()
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontsize(11);

        $section = $phpWord->addSection(
            [
                //untuk ukuran pada kertas 
                'marginTop' => Converter::cmTotwip(1.80),

                'marginBottom' => Converter::cmTotwip(1.80),
                'marginLeft' => Converter::cmTotwip(1.2),
                'marginRight' => Converter::cmTotwip(1.6),
            ]
        );
        $semuaBuku = Buku::find()->all();
        foreach ($semuaBuku as $buku) {
            $section->addText($buku->nama);
        }
        $section ->addListItem('List Item I', 0);
        $section ->addListItem('List Item I.a', 1);
        $section ->addListItem('List Item I.b', 1);
        $section ->addListItem('List Item II', 0);

        $filename = 'test.docx';
        $path = 'export/'. $filename;
        $xmlWriter = IOfactory::createWriter($phpWord, 'Word2007');
        $xmlWriter -> save($path);
        return $this -> redirect($path);
    }
}

 