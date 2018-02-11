<?php

namespace backend\controllers;

use app\models\Profession;
use common\models\UploadForm;
use Yii;
use app\models\Doctor;
use backend\models\DoctorSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DoctorController implements the CRUD actions for Doctor model.
 */
class DoctorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {



        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','update','delete','create'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];


//
//
//
//
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
    }

    /**
     * Lists all Doctor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DoctorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Doctor model.
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
     * Creates a new Doctor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Doctor();
        $model->status_id=1;
        $model->area_id=1;



        $profession_list_drop = ArrayHelper::map(Profession::find()->all(),'id','name');

        // save image
        $model_upload = new UploadForm();
//        if (Yii::$app->request->isPost) {
        if (isset($_FILES['UploadForm'])){
            $model_upload->imageFiles = UploadedFile::getInstances($model_upload, 'imageFiles');
            $full_names_path_image= $model_upload->upload();
            yii::error($full_names_path_image);
            if (!empty($full_names_path_image)) {
                $model->photo=  str_replace(Yii::$app->params['cut_path'],'',$full_names_path_image[0]);
            }
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,'profession_list_drop'=>$profession_list_drop,'model_upload'=>$model_upload,
        ]);
    }

    /**
     * Updates an existing Doctor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $profession_list_drop = ArrayHelper::map(Profession::find()->all(),'id','name');


        // save image
        $model_upload = new UploadForm();
//        if (Yii::$app->request->isPost) {
        if (isset($_FILES['UploadForm'])){
            $model_upload->imageFiles = UploadedFile::getInstances($model_upload, 'imageFiles');
            $full_names_path_image= $model_upload->upload();
            yii::error($full_names_path_image);
            if (!empty($full_names_path_image)) {
                $model->photo=  str_replace(Yii::$app->params['cut_path'],'',$full_names_path_image[0]);
            }
        }



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,'profession_list_drop'=>$profession_list_drop,'model_upload'=>$model_upload,
        ]);
    }

    /**
     * Deletes an existing Doctor model.
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
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Doctor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Doctor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
