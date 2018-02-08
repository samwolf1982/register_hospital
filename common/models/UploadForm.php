<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 2],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $u_id=Yii::$app->user->getId();
            $u_id= empty($u_id)?'anonim':$u_id;

//            cut_path
         //    Yii::$app->params['cut_path']   обрезка для переноса из бекенда web в фронтенд web
            $path_dir = Yii::$app->params['cut_path'].'/images/uploads/'.date('YMD') .'/'.$u_id.'/'.  uniqid();
            FileHelper::createDirectory($path_dir);
            $full_names=[];
            foreach ($this->imageFiles as $file) {
                // $full_name=$path_dir .'/'.    $file->baseName . '.' . $file->extension;
                $full_name=$path_dir .'/'.   uniqid() . '.' . $file->extension;
                $file->saveAs($full_name);
                $full_names[]=$full_name;
            }
            return $full_names;
        } else {
            return false;
        }
    }
}