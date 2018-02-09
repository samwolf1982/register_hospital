<?php

namespace backend\controllers;

use DateTime;
use Yii;
use app\models\Calendar;
use backend\models\CalendarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
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
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalendarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Calendar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *   'date' => 'Дата (год-мес-день)',
     */
    public function actionView($id)
    {

        // находим день потом берем из него создаем неделю 7 дней и в вюшку 7 моделей
        $model= $this->findModel($id);
        if ($model){
            $date = new DateTime($model->date);// c нее отcчет
            $day_week=date('w',$date->getTimestamp()); // смещение на количесвто дней от текущего дня до понедельника
            if ($day_week>1){
                $day_week=$day_week-1;
                $date->modify("-{$day_week} day");
            }elseif ($day_week==0){
                $day_week++;
                $date->modify("+{$day_week} day");
            }
            // поиск 7 моделей пон вт ср ...

            $day_list=[];
            foreach (range(0,6) as $item) {
                  $day_list[]= $date->format('Y-m-d');
                $date->modify("+1 day");
            }

            yii::error($day_list);
//            SELECT * FROM `calendar` WHERE `doctor_id` =500 AND `date` in ("2018-02-09","2018-02-10","2018-02-11","2018-02-12","2018-02-13");
       $calendar_list=     Calendar::find()->where(['doctor_id'=>$model->doctor_id])->andWhere(['in','date',$day_list])->orderBy(['date'=>SORT_ASC])->all();
       $day_week_list=["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"];
       $calendar_list_model=[];
       // проход по всему что нашлось и разметка по дням недели
            foreach ($calendar_list as $item) {
                $active_day_date = new DateTime($item->date);
                 $index_day=  date('w',$active_day_date->getTimestamp());
                $calendar_list_model[]=['name'=>$day_week_list[$index_day] . ' ( '.$item->date." )" ,'model'=>$item];
            }

            yii::error($calendar_list_model);
        }


        return $this->render('view', [
            'model' => $this->findModel($id),'calendar_list_model'=>$calendar_list_model,
        ]);
    }

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Calendar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Calendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


//        // находим день потом берем из него создаем неделю 7 дней и в вюшку 7 моделей
//        $model= $this->findModel($id);
//        if ($model){
//
//            $active_day_date = new DateTime($model->date);
//            $day_week=date('w'); // смещение на количесвто дней от текущего дня до понедельника
//            yii::error([$day_week]);
//        }






        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Calendar model.
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
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
