<?php

namespace app\controllers;


use Yii;
use app\models\Penerbit;
use app\models\PenerbitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// require 'vendor/autoload.php';
/**
 * PenerbitController implements the CRUD actions for Penerbit model.
 */
class PenerbitController extends Controller
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
     * Lists all Penerbit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenerbitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Penerbit model.
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
     * Creates a new Penerbit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penerbit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Penerbit model.
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
     * Deletes an existing Penerbit model.
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
     * Finds the Penerbit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penerbit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penerbit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Untuk Export ke Excel
    // public function actionImportExcel()
    // {
    //     $inputFile = 'exportpenerbitexcel/branches_file.xlsx';
    //     try{
    //         $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
    //         $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
    //         $objPHPExcel = $objReader->load($inputFile);
    //     }catch('Exception $e')
    //     {
    //         die('Error');
    //     }
    //     $sheet = $objPHPExcel->getSheet(0);
    //     $highestColumn = $sheet->getHighestColumn();

    //     for ( $row = 1; $row <= $hihestRow; $row++) 
    //     { 
    //         $rowData = $sheet->rangeToArray('A' .$row.':'.$highestColumn.$row,NULL,TRUE,FALSE');
    //             if ($row == 1)
    //              {
    //                 continue;
    //             }

    //             $branch = new Branches();
    //             $branch_id = $rowData[0][0];
    //     }
    // }
    // $spreadsheet = new Spreadsheet();
    // $sheet = $spreadsheet->getActiveSheet();
    // $sheet->setCellValue('A1', 'Hello World !');

    // $writer = new Xlsx($spreadsheet);
    // $writer->save('hello world.xlsx');
    
    }
