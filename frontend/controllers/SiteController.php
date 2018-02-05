<?php
namespace frontend\controllers;

use app\models\Order;
use app\models\Profession;
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
        $stage=1;
        if (Yii::$app->request->post()){
            $model_post=Yii::$app->request->post("Order");
            $model->cod=$model_post['cod'];

            yii::error(['in post 1']);
            $doc_id=Yii::$app->request->post("dokid");
            if (!empty( $model->cod) && !empty($doc_id)){
                $stage=3;
                ////                       все враччи по даной специальности  $model_profession->id
                    $selected_profesion=Profession::find()->where(['id'=>$doc_id])->one();
                    $doc_list=  $selected_profesion->doctors;
//                yii::error($doc_id);
//                yii::error($selected_profesion);
//                yii::error($doc_list);
                yii::error(['in post 3']);
            }elseif(!empty( $model->cod)){
                yii::error(['in post 2']);
                $model->client_name=$model_post['client_name'];
                $model->client_surname=$model_post['client_surname'];
                $model->client_patronymic=$model_post['client_patronymic'];
                $model->born=$model_post['born'];
                //$profession_list = ArrayHelper::map(Profession::find()->all(),'id','name');
                $profession_list = Profession::find()->where(1)->all();
                $stage=2;


//                if (!empty($model_profession->id) ){
//                    $stage=3;
////                       все враччи по даной специальности  $model_profession->id
//                    $selected_profesion=Profession::find()->where(['id'=>$model_profession->id])->all();
////                         yii::error($selected_profesion);
//                    $doc_list=  $selected_profesion->doctors;
//
//
//                    yii::error($doc_list);
//                    $tmp=[];
//                    foreach ($doc_list as $item) {
//                        $tmp[]=["d1"=>$item->id  ,"d2"=>$item->name,"d3"=>"risus@consequatdolorvitae.org",'d4'=>'dsadasad','d5'=>'sadasda','d6'=>'sdsa','d7'=>'dsadasda'];
//                    }
//                    $resultData=$tmp;
//
//                }
                //  yii::error($profession_list);
            }


        }



        return $this->render('index', [
            'model' => $model,'stringHash'=>$stringHash,'stage'=>$stage,'profession_list'=>$profession_list,'profession_list'=>$profession_list,'doc_list'=>$doc_list,'selected_profesion'=>$selected_profesion
        ]);
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
