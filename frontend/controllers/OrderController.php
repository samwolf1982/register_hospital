<?php

namespace frontend\controllers;

use app\models\Profession;
use Yii;
use app\models\Order;
use frontend\models\OrderSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
        $model_profession = new Profession();
        $profession_list = [];
        $dataProvider=[];


$stringHash=uniqid();

       // $model->load(Yii::$app->request->post());
        $stage=1;
        if (Yii::$app->request->post()){
            $model_post=Yii::$app->request->post("Order");
            $model->cod=$model_post['cod'];

            $model_post_profession=Yii::$app->request->post("Profession");
            $model_profession->id=$model_post_profession['id'];

            if (!empty( $model->cod)){
                $model->client_name=$model_post['client_name'];
                $model->client_surname=$model_post['client_surname'];
                $model->client_patronymic=$model_post['client_patronymic'];
                $model->born=$model_post['born'];
                $profession_list = ArrayHelper::map(Profession::find()->all(),'id','name');
                $stage=2;

                     if (!empty($model_profession->id) ){
                         $stage=3;
//                       все враччи по даной специальности  $model_profession->id
                         $selected_profesion=Profession::find()->where(['id'=>$model_profession->id])->one();
//                         yii::error($selected_profesion);
                       $doc_list=  $selected_profesion->doctors;


                         yii::error($doc_list);
                            $tmp=[];
                         foreach ($doc_list as $item) {
                             $tmp[]=["d1"=>$item->id  ,"d2"=>$item->name,"d3"=>"risus@consequatdolorvitae.org",'d4'=>'dsadasad','d5'=>'sadasda','d6'=>'sdsa','d7'=>'dsadasda'];
                               }
                         $resultData=$tmp;
//                         $resultData = [
//                             ["d1"=>1,"d2"=>"Cyrus","d3"=>"risus@consequatdolorvitae.org",'d4'=>'dsadasad','d5'=>'sadasda','d6'=>'sdsa','d7'=>'dsadasda'],
//                             ["d1"=>1,"d2"=>"Cyrus","d3"=>"risus@consequatdolorvitae.org",'d4'=>'dsadasad','d5'=>'sadasda','d6'=>'sdsa','d7'=>'dsadasda'],
//                             ["d1"=>1,"d2"=>"Cyrus","d3"=>"risus@consequatdolorvitae.org",'d4'=>'dsadasad','d5'=>'sadasda','d6'=>'sdsa','d7'=>'dsadasda'],
//                             ["d1"=>1,"d2"=>"Cyrus","d3"=>"risus@consequatdolorvitae.org",'d4'=>'dsadasad','d5'=>'sadasda','d6'=>'sdsa','d7'=>'dsadasda'],
//                             ["d1"=>1,"d2"=>"Cyrus","d3"=>"risus@consequatdolorvitae.org",'d4'=>'dsadasad','d5'=>'sadasda','d6'=>'sdsa','d7'=>'dsadasda'],
//                             ["d1"=>1,"d2"=>"Cyrus","d3"=>"risus@consequatdolorvitae.org",'d4'=>'dsadasad','d5'=>'sadasda','d6'=>'sdsa','d7'=>'dsadasda'],
//                         ];

//                         $dataProvider = new ArrayDataProvider([
//                             'allModels' => $resultData,
//                             'pagination' => false, // 可选 不分页
//                         ]);

                         $dataProvider = new ArrayDataProvider([
                             'allModels' => $resultData,
//                             'pagination' => [
//                                 'pageSize' => 10,
//                             ],
                         ]);

//                         $dataProvider = new ArrayDataProvider([
//                             'key'=>'id',
//                             'allModels' => $items,
//                             'pagination' => false, // 可选 不分页
//                             'sort' => [
//                                 'attributes' => ['id', 'name', 'email'],
//                             ],
//                         ]);


                     }
              //  yii::error($profession_list);
            }


        }





// yii::error([$stage,$model->cod]);

       // if ($model->load(Yii::$app->request->post()) && $model->save()) {
         //   return $this->render(['create', 'id' => $model->id,'model'=>$model,'stringHash'=>$stringHash]);
           // return $this->redirect(['view', 'id' => $model->id]);
       // }

        return $this->render('create', [
            'model' => $model,'stringHash'=>$stringHash,'stage'=>$stage,'profession_list'=>$profession_list,'model_profession'=>$model_profession,'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Updates an existing Order model.
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
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
