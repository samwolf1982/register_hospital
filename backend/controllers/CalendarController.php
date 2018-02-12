<?php

namespace backend\controllers;

use app\models\DayPeriod;
use app\models\Doctor;
use DateTime;
use Yii;
use app\models\Calendar;
use backend\models\CalendarSearch;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
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


    }
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

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
            'dataProvider' => $dataProvider

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

         //   yii::error(['day'=>$day_week]);
            if ($day_week>1){
                $day_week=$day_week-1;
                $date->modify("-{$day_week} day");
            }elseif ($day_week==0){
//                $day_week++;
                $day_week=6;
                $date->modify("-{$day_week} day");
                //$date->modify("+{$day_week} day");
            }
            // поиск 7 моделей пон вт ср ...

            $day_list=[];
            foreach (range(0,6) as $item) {
                  $day_list[]= $date->format('Y-m-d');
                $date->modify("+1 day");
            }

          //  yii::error($day_list);
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

           // yii::error($calendar_list_model);
        }
        $next_week_date=  new DateTime($calendar_list_model[0]['model']->date);// понедельник сделущей недели
        $next_week_date->modify("+7 day");
        $next_week_date_model= Calendar::find()->where(['doctor_id'=>$model->doctor_id,'date'=>$next_week_date->format('Y-m-d')])->one();
        $next_week_date->modify("-14 day");
        $prew_week_date_model= Calendar::find()->where(['doctor_id'=>$model->doctor_id,'date'=>$next_week_date->format('Y-m-d')])->one();


        $model_monday = new DynamicModel( ['id_first_week_day'=> $calendar_list_model[0]['model']->id]);

        $model_monday->load($_POST);
        if (isset($_POST['DynamicModel'])){// клонирование в следущую неделю только если есть 7 штук
            $count=count($calendar_list_model);
            if ($count==7){
                // удалить все что дальше текущей недели
//                Calendar::deleteAll(['>','date',$next_week_date->format('Y-m-d')]);
                $next_week_date->modify("+14 day");
             $fordel=   Calendar::find()->where(['doctor_id'=>$model->doctor_id])->andWhere(['>=','date',$next_week_date->format('Y-m-d')])->all();

              //  yii::error( [count( $fordel),'doctor_id'=>$model->doctor_id, $next_week_date->format('Y-m-d') ]);
                foreach ($fordel as $item) {
                    $item->delete();
             }
             $d=date('Y-m-d');
                $colect_new_calendar=[];
                foreach ($calendar_list_model as $item) {
                                $o= new Calendar();
                                   $o->doctor_id=$item['model']->doctor_id;
                                   $doc_day= new DateTime($item['model']->date);
                                   $doc_day->modify("+7 day");
                                   $o->date= $doc_day->format('Y-m-d') ;
                                   $o->timetable= $this->clear_close_day(  $item['model']->timetable);
                                   $o->created_at=$d;
                                   $o->timetable_work=$item['model']->timetable_work;
                                 //  $o->validate();
                               //   yii::error(['did'=>$item['model']->doctor_id, $o->errors]);
                                   $o->save();

                    if ($o){
                        $colect_new_calendar[]=$o;
                    }
                    $next_week_date_model=$colect_new_calendar[0];
//                    [['date', 'doctor_id', 'created_at'], 'required'],
//            [['date', 'created_at'], 'safe'],
//            [['doctor_id'], 'integer'],
//            [['timetable'], 'string'],
                                        }

               // $next_week_date_model=false;

                Yii::$app->session->setFlash('success', "Вы удачно создали график на следущие 7 дней");
            }else{

                Yii::$app->session->setFlash('warning', "Для клонирование нужно выбрать полную неделю. у вас сейчас только {$count} дней");
            }
        }




        return $this->render('view', [
            'model' => $this->findModel($id),'calendar_list_model'=>$calendar_list_model,'model_monday'=>$model_monday,'next_week_date_model'=>$next_week_date_model,
            'prew_week_date_model'=>$prew_week_date_model,
        ]);
    }


    //чиста json от close day
    //"id":21,"type":"text","val
    private function clear_close_day($json){
        $res=[];
          if (empty($json)){ $res=$json;}else{
                      $j= json_decode($json);
                      if (is_array($j)){
                          foreach ($j as $i) {
                                 $res[]=["id"=>$i->id,"type"=>$i->type,"text"=>$i->text,"val"=>$i->val];
                          }
                          $res=json_encode($res);
                      }else{
                          $res=$json;
                      }

          }

        return $res;
    }

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Calendar();
        $model->created_at=date('Y-m-d');


        $day_periods=DayPeriod::find()->where(1)->all();

        $check_names=[];
        $options_list=[];
        foreach ($day_periods as $day_period) {
//            $check[]=$day_period->id;
            $check_names[]=$day_period->name;
            $options_list[]=['name'=>$day_period->name, 'id'=>$day_period->id];
        }

        $value_name=$_POST['tags2'];


        $doctor_list=Doctor::find()->where(1)->all();

        $doctor_list_drop=[];
        foreach ($doctor_list as $item) {
//            [['name', 'surname', 'patronymic', 'phone'], 'string', 'max' => 255],
            $doctor_list_drop[$item->id]= $item->id.") ".  $item->surname.' '.$item->name." ".$item->patronymic." (".$item->profession->name.") ";
        }




        if (Yii::$app->request->post()){
            $p=Yii::$app->request->post('tags2');
            if (!empty($p)){

                $parr_ids = explode(",", $p);
//         if (!is_array($parr_ids)){
//             yii::error(['post not arr'=>$p]);
//             $parr_ids=[];
//             $parr_ids[]=intval($p);
//         }
//         yii::error(['ppp'=>$parr_ids]);

                //$list_period[]=['id'=>$f++,'type'=>'empty_day', 'val'=> "В этот день приёма нет.",];
                $list_period=[];
                foreach ($parr_ids as $parr_id) {

                    $o=  DayPeriod::find()->where(['id'=>$parr_id])->one();
                    yii::error(['ppp'=>$parr_ids,'o'=>$o]);
                    if ($o){
                        $list_period[]=['id'=>$o->id,'type'=>$o->type, 'val'=> $o->name];
                    }
                }


                $timetable= json_encode($list_period);
//         yii::error(['sjon'=>$timetable]);
                if (empty($timetable)){
                    $model->timetable='';
                }else{
                    $model->timetable=$timetable;
                }
            }else{
                $model->timetable='';
            }







        }








        $model->load(Yii::$app->request->post());
        $model->validate();
        yii::error($model->errors);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model            ,'doctor_list_drop'=>$doctor_list_drop,'options_list'=>$options_list,'value_name'=>$value_name,
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


        $day_periods=DayPeriod::find()->where(1)->all();

        $check_names=[];
        $options_list=[];
        foreach ($day_periods as $day_period) {
//            $check[]=$day_period->id;
            $check_names[]=$day_period->name;
            $options_list[]=['name'=>$day_period->name, 'id'=>$day_period->id];
       }



       $json=json_decode($model->timetable);
//        yii::error($model->timetable);
        $check=[];
        if (!empty($json)){
            foreach ($json as $item) {
                $check[]=$item->id;
            }

        }


       $value_name=implode (',',$check);




        $model_d= new DynamicModel(compact('check'));



if (Yii::$app->request->post()){
    $p=Yii::$app->request->post('tags2');
     if (!empty($p)){

         $parr_ids = explode(",", $p);
//         if (!is_array($parr_ids)){
//             yii::error(['post not arr'=>$p]);
//             $parr_ids=[];
//             $parr_ids[]=intval($p);
//         }
//         yii::error(['ppp'=>$parr_ids]);

         //$list_period[]=['id'=>$f++,'type'=>'empty_day', 'val'=> "В этот день приёма нет.",];
         $list_period=[];
         foreach ($parr_ids as $parr_id) {

             $o=  DayPeriod::find()->where(['id'=>$parr_id])->one();
           //  yii::error(['ppp'=>$parr_ids,'o'=>$o]);
             if ($o){
                 $list_period[]=['id'=>$o->id,'type'=>$o->type, 'val'=> $o->name];
             }
         }


         $timetable= json_encode($list_period);
//         yii::error(['sjon'=>$timetable]);
         if (empty($timetable)){

             $model->timetable='';
         }else{
             $model->timetable=$timetable;
         }
     }else{
         yii::error(['mimi']);
         $model->timetable='';
     }







}


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,'day_periods'=>$day_periods,'model_d'=>$model_d,'check_names'=>$check_names,'value_name'=>$value_name,'options_list'=>$options_list
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

        // находим день потом берем из него создаем неделю 7 дней и в вюшку 7 моделей
        $model= $this->findModel($id);
        if ($model){
            $date = new DateTime($model->date);// c нее отcчет
            $day_week=date('w',$date->getTimestamp()); // смещение на количесвто дней от текущего дня до понедельника

            //   yii::error(['day'=>$day_week]);
            if ($day_week>1){
                $day_week=$day_week-1;
                $date->modify("-{$day_week} day");
            }elseif ($day_week==0){
//                $day_week++;
                $day_week=6;
                $date->modify("-{$day_week} day");
                //$date->modify("+{$day_week} day");
            }
            // поиск 7 моделей пон вт ср ...

            $day_list=[];
            foreach (range(0,6) as $item) {
                $day_list[]= $date->format('Y-m-d');
                $date->modify("+1 day");
            }

            //  yii::error($day_list);
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

            // yii::error($calendar_list_model);
        }
        $next_week_date=  new DateTime($calendar_list_model[0]['model']->date);// понедельник сделущей недели
        $next_week_date->modify("+7 day");
        $next_week_date_model= Calendar::find()->where(['doctor_id'=>$model->doctor_id,'date'=>$next_week_date->format('Y-m-d')])->one();
        $next_week_date->modify("-14 day");
        $prew_week_date_model= Calendar::find()->where(['doctor_id'=>$model->doctor_id,'date'=>$next_week_date->format('Y-m-d')])->one();

//        $model_monday = new DynamicModel( ['id_first_week_day'=> $calendar_list_model[0]['model']->id]);
//        $model_monday->load($_POST);



        if (count($calendar_list_model)>1){
            // проход по всем моделям и если совпадение удалить
            foreach ($calendar_list_model as $key =>$item) {
                                    if ($item['model']->id==$id){ // check -- delete
                                               $this->findModel($id)->delete();
                                              if ($key==0){
                                                  return $this->redirect(['calendar/view','id'=>$calendar_list_model[1]['model']->id]);
                                              }else{
                                                  return $this->redirect(['calendar/view','id'=>$calendar_list_model[0]['model']->id]);
                                              }
                                    }
                 }
         //   return $this->redirect(['calendar/view','id'=>$calendar_list_model[0]['model']->id]);
        }elseif(count($calendar_list_model)==1){     // одна модель делет и индекс
                    $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else{
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }

        $this->findModel($id)->delete();
        return $this->redirect(['index']);

  // return $this->redirect(['calendar/view','id'=>$id]);



        return $this->render('view', [
            'model' => $this->findModel($id),'calendar_list_model'=>$calendar_list_model,'model_monday'=>$model_monday,'next_week_date_model'=>$next_week_date_model,
            'prew_week_date_model'=>$prew_week_date_model,
        ]);

//        $this->findModel($id)->delete();


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
