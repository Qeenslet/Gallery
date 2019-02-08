<?php
/**
 * Created by PhpStorm.
 * User: gulidoveg
 * Date: 27.10.17
 * Time: 16:55
 */

namespace app\models;
use yii;
use yii\base\Model;
use app\models\Picture;
use app\models\Imaginator;

class UploadForm extends Model
{

    public $imageFiles;
    private $responseResult;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }


    public function upload()
    {
        if ($this->validate())
        {
            foreach ($this->imageFiles as $file)
            {
                $newFile = $this->hashName($file->baseName, $file->extension);
                $tmp = [];
                $file->saveAs('uploads/' . $newFile['fullname']);
                $picture = new Picture();
                $picture->filename = $newFile['fullname'];
                $picture->user_id = Yii::$app->user->id;
                $picture->thumbname = 'pre_' . $newFile['part1'] . '.jpg';
                $picture->birthname = $file->baseName . '.' . $file->extension;
                $picture->save();
                $tmp['src'] = 'pre_' . $newFile['part1'] . '.jpg';
                $tmp['src2'] =  $newFile['fullname'];
                $tmp['filename'] = $file->baseName . '.' . $file->extension;
                $imaginator = new Imaginator($newFile['fullname'], '');
                $imaginator->saveCropped();
                $this->responseResult['images'][] = $tmp;
            }
            $this->responseResult['success'] = true;
            return true;
        }
        else
        {
            $this->responseResult['success'] = false;
            $this->responseResult['error'] = 'Файл не прошел валидацию!';
            return false;
        }
    }


    /**
     * Генерация уникального имени
     * @param $baseName
     * @param $extension
     * @return array
     */
    private function hashName($baseName, $extension)
    {
        $part1 = md5($baseName);
        $fullFilename = $part1 . '.' . $extension;
        if ($this->checkNameExistance($fullFilename))
        {
            $name = $baseName . uniqid();
            return $this->hashName($name, $extension);
        }
        return array('fullname' => $fullFilename, 'part1' => $part1);
    }


    /**
     * проверка уникальности имени
     * @param $fullname
     * @return int|string
     */
    private function checkNameExistance($fullname)
    {
        return Picture::find()
            ->where(['filename' => $fullname])
            ->count();
    }


    /**
     * Получение результата для генерации json
     * @return mixed
     */
    public function getResult()
    {
        return $this->responseResult;
    }



}