<?php

namespace app\controllers;

use Yii;
use app\models\Anggota;
use app\models\AnggotaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ArrayHelper;
use PhpOffice\PhpWord\IOfactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
/**
 * AnggotaController implements the CRUD actions for Anggota model.
 */
class AnggotaController extends Controller
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
     * Lists all Anggota models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnggotaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Anggota model.
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
     * Creates a new Anggota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Anggota();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Anggota model.
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
     * Deletes an existing Anggota model.
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
     * Finds the Anggota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Anggota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Untuk export Anggota ke word

    public function actionDataAng()
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
            'Data Anggota',
            $headerStyle,
            $fontStyle,
            $paragraphCenter
        );

        $section->addText(
            'DATA ANGGOTA',
            $headerStyle,
            $paragraphCenter
        );

        $section->addTextBreak(1);
        $judul = $section->addTextRun($paragraphCenter);

        $judul->addText('Keterangan', $fontStyle);
        $judul->addText('Tabel', ['italic' =>true]);
        $judul->addText('Anggota', ['bold' =>true]);

        $table = $section->addTable([
            'alignment' => 'center',
            'bgColor' => 6,
            'borderSize' => 6,
        ]);

        $table->addRow(null);
        $table->addCell(500)->addText('NO', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Nama', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Alamat', $headerStyle, $paragraphCenter);
        $table->addCell(200)->addText('Telepon', $headerStyle, $paragraphCenter);
        $table->addCell(200)->addText('Email', $headerStyle, $paragraphCenter);

        $semuaAnggota = Anggota::find()->all();
        $nomor = 1;
        foreach ($semuaAnggota as $anggota) {
        $table->addRow(null);
        $table->addCell(500)->addText($nomor++, null, $headerStyle);
        $table->addCell(5000)->addText($anggota->nama, null, $paragraphCenter);
        $table->addCell(5000)->addText($anggota->alamat, null, $paragraphCenter);
        $table->addCell(5000)->addText($anggota->telepon, null, $paragraphCenter);
        $table->addCell(5000)->addText($anggota->email, null, $paragraphCenter);

        }

        $filename = time() . 'Data-anggota.docx';
        $path = 'exportanggota/' . $filename;
        $xmlWriter = IOfactory::createWriter($phpWord, 'Word2007');
        $xmlWriter -> save($path);
        return $this -> redirect($path);

    }
}
