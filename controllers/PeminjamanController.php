<?php

namespace app\controllers;

use Yii;
use app\models\Peminjaman;
use app\models\PeminjamanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ArrayHelper;
use PhpOffice\PhpWord\IOfactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

/**
 * PeminjamanController implements the CRUD actions for Peminjaman model.
 */
class PeminjamanController extends Controller
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
     * Lists all Peminjaman models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PeminjamanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Peminjaman model.
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
     * Creates a new Peminjaman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Peminjaman();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Peminjaman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Peminjaman model.
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
     * Finds the Peminjaman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Peminjaman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Peminjaman::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //untuk export ke word
    public function actionDataPem()
    {
        $PhpWord = new phpWord();
        $section = $PhpWord->addSection(
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
            'Data Peminjaman',
            $headerStyle,
            $fontStyle,
            $paragraphCenter
        );

        $section->addText(
            'DATA PEMINJAMAN BUKU',
            $headerStyle,
            $paragraphCenter

        );

        $section->addTextBreak(1);

        $judul = $section->addTextRun($paragraphCenter);

        $judul->addText('Keterangan dari ', $fontStyle);
        $judul->addText('Tabel ', ['italic' =>true]);
        $judul->addText('Peminjaman ', ['bold' =>true]);

        $table = $section->addtable([
            'alignment' => 'center',
            'bgColor' => 6,
            'borderSize' => 6,
        ]);
        $table->addRow(null);
        $table->addCell(500)->addText('NO', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Nama Buku', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Nama Anggota', $headerStyle, $paragraphCenter);
        $table->addCell(200)->addText('Tanggal Pinjam', $headerStyle, $paragraphCenter);
        $table->addCell(200)->addText('Tanggal Kembali', $headerStyle, $paragraphCenter);

        $semuaPeminjaman = Peminjaman::find()->all();
        $nomor = 1;
        foreach ($semuaPeminjaman as $peminjaman) {
            $table->addRow(null);
            $table->addCell(500)->addText($nomor++, null, $headerStyle, $paragraphCenter);
            $table->addCell(5000)->addText($peminjaman->getBuku(), null, $paragraphCenter);
            $table->addCell(5000)->addText($peminjaman->getAnggota(), null, $paragraphCenter);
            $table->addCell(5000)->addText($peminjaman->tanggal_pinjam, null, $paragraphCenter);
            $table->addCell(5000)->addText($peminjaman->tanggal_kembali, null, $paragraphCenter);
        }
        $filename = time() . 'Data-Pem.docx';
        $path = 'exportpeminjaman/' . $filename;
        $xmlWriter = IOfactory::createWriter($PhpWord, 'Word2007');
        $xmlWriter -> save($path);
        return $this -> redirect($path);
    }
}
