<?php

namespace app\controllers;

use Yii;
use app\models\Petugas;
use app\models\PetugasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ArrayHelper;
use PhpOffice\PhpWord\IOfactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

/**
 * PetugasController implements the CRUD actions for Petugas model.
 */
class PetugasController extends Controller
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
     * Lists all Petugas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PetugasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Petugas model.
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
     * Creates a new Petugas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Petugas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Petugas model.
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
     * Deletes an existing Petugas model.
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
     * Finds the Petugas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Petugas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Petugas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //untuk Export Petugas ke word
    public function actionDataPet()
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
            'Data Petugas',
            $headerStyle,
            $fontStyle,
            $paragraphCenter
        );

        $section->addText(
            'DATA PETUGAS',
            $headerStyle,
            $paragraphCenter
        );

        $section->addTextBreak(1);

        $judul = $section->addTextRun($paragraphCenter);

        $judul->addText('Data dari ', $fontStyle);
        $judul->addText('Petugas', ['bold' =>true]);

         $judul = $section->addTextRun($paragraphCenter);

        $judul->addText('Ini adalah keterangan dari ', $fontStyle);
        $judul->addText(' Data Petugas', ['italic' =>true]);

        $table = $section->addTable([
            'alignment' => 'center',
            'bgColor' => 6,
            'borderSize' => 6,
        ]);

        $table->addRow(null);
        $table->addCell(500)->addText('No', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Nama', $headerStyle, $paragraphCenter);
        $table->addCell(200)->addText('Alamat', $headerStyle, $paragraphCenter);
        $table->addCell(200)->addText('Telepon', $headerStyle, $paragraphCenter);
        $table->addCell(200)->addText('Email', $headerStyle, $paragraphCenter);

        $semuaPetugas = Petugas::find()->all();
        $nomor = 1;
        foreach ($semuaPetugas as $petugas) {
            $table->addRow(null);
            $table->addCell(500)->addText($nomor++, null, $headerStyle, $paragraphCenter);
            $table->addCell(5000)->addText($petugas->nama, null);
            $table->addCell(5000)->addText($petugas->alamat, null, $paragraphCenter);
            $table->addCell(5000)->addText($petugas->telepon, null, $paragraphCenter);
            $table->addCell(5000)->addText($petugas->email, null, $paragraphCenter);
        }

        $filename = time() . 'DataPet.docx';
      $path = 'exportpetugas/' . $filename;
      $xmlWriter = IOfactory::createWriter($phpWord, 'Word2007');
      $xmlWriter -> save($path);
      return $this -> redirect($path);

    }
}
