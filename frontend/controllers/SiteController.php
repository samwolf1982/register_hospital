<?php
namespace frontend\controllers;

use app\models\Calendar;
use app\models\DayPeriod;
use app\models\Doctor;
use app\models\Order;
use app\models\Profession;
use DateTime;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ConflictHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new Order();
        $profession_list = [];
        $dataProvider=[];
        $doc_list=[];
        $selected_profesion=null;
        $stringHash=uniqid();
        $calendar_list=[];
        $stage=1;
        $next_week=true;
        if (Yii::$app->request->post()){
            $model_post=Yii::$app->request->post("Order");
            $model->cod=$model_post['cod'];
            yii::error(['in post 1']);
            $model->profession_id=$model_post[ 'profession_id'];
            //Yii::$app->request->post("dokid");
            if (!empty( $model->cod) && !empty($model->profession_id) && !Yii::$app->request->post("change")){
                $stage=3;
                ////                       все враччи по даной специальности  $model_profession->id
                    $selected_profesion=Profession::find()-> where(['id'=>$model->profession_id])->one();
                    $doc_list=  $selected_profesion->doctors;

                    $arr_doc_id=[];
                $doc_list_main=[];
                $date = new DateTime('NOW');
                $active_day_date = new DateTime('NOW');
                $day_week=date('w'); // смещение на количесвто дней от текущего дня до понедельника

              //  Yii::error([ 'me-date'=> date('Y/m/d H:i:s')]);
                if ($day_week==6){  $date->modify('+2 day');// суботта + 2 дня
                }elseif ($day_week==0){
                    $date->modify('+1 day');   // неділя +1ы
                } else{
                    $day_week-=1;
                    $date->modify("-{$day_week} day");
                }
                if (Yii::$app->request->post("next_week")==7){ // +7 если другая неделя
                    $date->modify('+7 day');
                    $next_week=false;
                }

                foreach ($doc_list as $doctor) {
                    $calendar_list=[];

                    $arr_doc_id[]=$doctor->id;

                    foreach (['Пн','Вт','Ср','Чт','Пт','Сб','Вс',
                             ] as $id) {
                        $tj=$date->format('Y-m-d');
                        $tmp_cal=[];
                            //самій быстрый вариант при множестве трабла IN ( 12 2 2 23 ...)
                            $o= Calendar::find()->select(['timetable','id','timetable_work'])->where(['doctor_id'=>$doctor->id,'date'=>$tj])->limit(1)->one();
                               $json_arr = json_decode($o->timetable);
                               $tmp_cal=['doc_id'=>$doctor->id,'timetable'=> $json_arr];
                               $active_day=true;

                         $numnber_day=date('z'); // номер дня в году     44
                        $numnber_day_bd=date('z',$date->getTimestamp()); // номер дня в году     44
                        if ($numnber_day > $numnber_day_bd ){ $active_day=false;}
//                        yii::error($o);
                               $calendar_list[]=['doclist'=>$tmp_cal,'day_name'=> sprintf ("%s, %d",$id,$date->format('d')),'active_day'=>$active_day,'calendar_id'=>$o->id,'timetable_work'=>$o->timetable_work];
                        unset($tmp_cal);
                        $date->modify('+1 day');
                    }
                    $date->modify('-8 day');
                    $doc_list_main[]=['doctor'=>$doctor,'calendar_list'=>$calendar_list];
                    unset($calendar_list);
                    $date->modify('+1 day');
                    } // end $doc_list as $doctor


// yii::error($doc_list_main);
                $doc_list= $doc_list_main;

                yii::error(['in post 3']);
            }elseif(!empty( $model->cod)){
                yii::error(['in post 2']);
                $model->client_name=$model_post['client_name'];
                $model->client_surname=$model_post['client_surname'];
                $model->client_patronymic=$model_post['client_patronymic'];
                $model->born=$model_post['born'];
                $profession_list_drop = ArrayHelper::map(Profession::find()->all(),'id','name');
                $profession_list = Profession::find()->where(1)->all();
                $stage=2;

            }


        }



        return $this->render('index', [
            'model' => $model,'stringHash'=>$stringHash,'stage'=>$stage,'profession_list'=>$profession_list,'profession_list'=>$profession_list,'doc_list'=>$doc_list,'selected_profesion'=>$selected_profesion,
            'profession_list_drop'=>$profession_list_drop,'next_week'=>$next_week,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionCheckorder()
    {
        $param=[1,2,3];
        $name='nameme';
        $message=' $message $message $message';
//        ?cod=asdasd&doc_id=261&calendar_id=18761&day_id=2

        $doc=Doctor::find()->where(['id'=>$_GET['doc_id']])->one();
        if ($doc){
            $doc_spec=$doc->profession->name;
        }

        $clinic_name=Yii::$app->params['clinic_name'];
        $adress=Yii::$app->params['street_name'];
        $to_do="Прием ".$doc_spec .'a';

        $calendar=Calendar::find()->where(['id'=>$_GET['calendar_id']])->one();

        if ($calendar){
            $calendar_id=$_GET['calendar_id'];
            $json_timetable= json_decode( $calendar->timetable);
            $day_id=$_GET['day_id'];
            foreach ($json_timetable as $item) {
                if ($item->id==$day_id){ // cовпадение по ид
                    $time= $item->val;
                    break;
                }
            }



            $m_list=["","Января", "Февраля", "Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря"];
            $m=$m_list[date('n',     strtotime($calendar->date))];
            $date=date("j-{$m}-Y",strtotime($calendar->date));
//          var_dump($json_timetable);
//          die();
        }



//        $time="13:00";
        $doc_order="Прием по талону.";
        $doc_name=$doc->name." ".$doc->surname.' '.$doc->patronymic;;
        $cod=$_GET['cod'];  // simple validate

        return $this->renderPartial('checkorder',
            compact('clinic_name','adress','doc_spec','to_do','date','time','doc_order','cod','doc_name','calendar_id','day_id'));
    }




    /**
     * create order
     *
     * @return mixed
     */
    public function actionSuccess()
    {


   //  http://localhost5/site/checkorder?cod=asdasd&doctor_id=261&calendar_id=18761&day_id=2

//        [['cod', 'doctor_id', 'period_id', 'date', 'date_created'], 'required'],

        $calendar=Calendar::find()->where(['id'=>$_GET['calendar_id']])->one();
        $hash=md5($calendar->doctor_id.'_'.$_GET['calendar_id'].'_'.$_GET['day_id']);
        $present_order=Order::find()->where(['hash'=>$hash])->one();

        if ($present_order){
            throw new ConflictHttpException('Невозможно подать заявку на данное время, возможно кто-то раньше уже сделал заявку на это время, попробуйте выбрать другое время');
        }

        $order =new Order();
        $order->cod=$_GET['cod'];
        $calendar=Calendar::find()->where(['id'=>$_GET['calendar_id']])->one();
        $order->doctor_id=$calendar->doctor_id;
        $order->doctor_name=$calendar->doctor->surname.' '.$calendar->doctor->name.' '.$calendar->doctor->patronymic.' ('.$calendar->doctor->profession->name.")";


      $d=  DayPeriod::find()->where(['id'=>$_GET['day_id']])->one();

      $time_value="ошибка такой записи в бд не существует";
      if ($d) {
          $time_value = $d->name;
          $json=   json_decode( $calendar->timetable,true);
          if (!empty( $json)){
              foreach ($json as &$item_json) {
                                 if ($item_json['id']==$_GET['day_id']){
                                     $item_json['status']='close';
                                 }
                     }
                     $calendar->timetable=json_encode($json);
              $calendar->save();
                     unset($item_json);

          }



      }
          $order->time_value=$time_value;







        $order->period_id=$_GET['day_id'];
        $order->date=$calendar->date;
        $order->hash=$hash;
//        2018-02-07 06:20:16
        $order->date_created=date("Y-m-d H:i:s");

        if ($order->validate()){
$order->save();
        }else{
            throw new ConflictHttpException('Not validate');
        }





        //



        $doc=Doctor::find()->where(['id'=>$calendar->doctor_id])->one();
        if ($doc){
            $doc_spec=$doc->profession->name;
        }

        $clinic_name=Yii::$app->params['clinic_name'];
        $adress=Yii::$app->params['street_name'];
        $to_do="Прием ".$doc_spec .'a';

        $calendar=Calendar::find()->where(['id'=>$_GET['calendar_id']])->one();

        if ($calendar){
            $calendar_id=$_GET['calendar_id'];
            $json_timetable= json_decode( $calendar->timetable);
            $day_id=$_GET['day_id'];
            foreach ($json_timetable as $item) {
                if ($item->id==$day_id){ // cовпадение по ид
                    $time= $item->val;
                    break;
                }
            }



            $m_list=["","Января", "Февраля", "Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря"];
            $m=$m_list[date('n',     strtotime($calendar->date))];
            $date=date("j-{$m}-Y",strtotime($calendar->date));
//          var_dump($json_timetable);
//          die();
        }



//        $time="13:00";
        $doc_order="Прием по талону.";
        $doc_name=$doc->name." ".$doc->surname.' '.$doc->patronymic;;
        $cod=$_GET['cod'];  // simple validate


        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['hostingemail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Новая запись на прием')
            ->setTextBody('У вас на сайте новая запись на прием')
            ->setHtmlBody('<b>Номер страхового полиса: '.$order->cod.'</b><br><b>Врач: '.$doc_name.'</b><br><b>Дата: '.$date.'</b><br><b>Время: '.$time_value.'</b>')
            ->send();


        return $this->render('success',
            compact('clinic_name','adress','doc_spec','to_do','date','time','doc_order','cod','doc_name','calendar_id','day_id','time_value'));
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
