<?php

namespace app\controllers;

class AdminController extends \yii\web\Controller
{
	// public function behaviors()
	// {
	// 	return [
 //            'access' => [
 //                'class' => AccessControl::className(),
 //                'only' => ['index'],
 //                'rules' => [
 //                    [
 //                        'actions' => ['index'],
 //                        'allow' => true,
 //                        'roles' => ['@'],
 //                    ],
 //                ],
 //            ],
 //            'verbs' => [
 //                'class' => VerbFilter::className(),
 //                'actions' => [
 //                    'delete' => ['POST'],
 //                ],
 //            ],
 //        ];
	// }
    public function actionIndex()
    {
        return $this->render('index');
    }

}
