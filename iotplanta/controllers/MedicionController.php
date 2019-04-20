<?php

namespace app\controllers;

use Yii;
use app\models\Medicion;
use app\models\MedicionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MedicionController implements the CRUD actions for Medicion model.
 */
class MedicionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' =>['mykey'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Medicion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MedicionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //obtener dia y hora actual
        $diaActual = date('Y-m-d');

        $diaActual1 = $diaActual." 00:00:00";
        $diaActual2 = $diaActual." 23:59:59";
        //consulta para traer las humedades
        $query = Medicion::find();
        $mediciones = $query->where(['between', 'fecha', $diaActual1, $diaActual2 ])->all();        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mediciones' =>$mediciones
        ]);
    }

    /**
     * Displays a single Medicion model.
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
     * Creates a new Medicion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Medicion();

        if($model->load(Yii::$app->request->post())->mykey == "ABC123")
        {
            

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
        
    }

    /**
     * Updates an existing Medicion model.
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
     * Deletes an existing Medicion model.
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
     * Finds the Medicion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Medicion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Medicion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
