<?php
/**
 * Created by PhpStorm.
 * User: gulidoveg
 * Date: 18.10.17
 * Time: 16:36
 */

namespace app\controllers;

use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\Picture;
use app\models\UploadForm;
use yii\web\UploadedFile;

class GalleryController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['display', 'mygallery'],
                'rules' => [
                    ['allow' => true,
                     'actions' => ['display'],
                     'roles' => ['?']
                    ],
                    ['allow' => true,
                     'actions' => ['mygallery', 'display', 'delete'],
                     'roles' => ['@']
                    ],
                ]
            ]
        ];
    }

    public function actionDisplay($filename)
    {
        $procced = true;
        $where1 = ['filename' => $filename];
        $where2 = ['thumbname' => $filename];
        $picture = Picture::find()->andWhere($where1)->orWhere($where2)->one();
        if ($picture)
        {
            $procced = false;
            if ($picture->user_id == Yii::$app->user->id) $procced = true;
        }
        if ($procced)
        {
            \Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
            \Yii::$app->response->headers->add('content-type','image/png');
            \Yii::$app->response->data = file_get_contents('uploads/' . $filename);
            return \Yii::$app->response;
        }
        throw new \yii\web\NotFoundHttpException;
    }


    public function actionMygallery()
    {
        $pictures = Picture::find()->where(['user_id' => Yii::$app->user->id])->all();

        $model = new UploadForm();

        if (Yii::$app->request->isPost)
        {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
            return json_encode($model->getResult());
        }
        return $this->render('gallery', ['images' => $pictures, 'model' => $model]);
    }



    public function beforeAction($action)
    {
        if ($action->id == 'delete')
        {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    public function actionDelete()
    {
        $post = Yii::$app->request->post();
        $filename = !empty($post['filename']) ? $post['filename'] : null;
        $result['success'] = false;
        if ($filename)
        {
            $picture = Picture::find()->where(['filename' => $filename])->one();
            if ($picture)
            {
                try
                {
                    unlink('uploads/' . $picture['filename']);
                    unlink('uploads/' . $picture['thumbname']);
                    $picture->delete();
                    $result['success'] = true;
                }
                catch (Exception $e)
                {
                    $result['error'] = $e->getMessage();
                }
            }
        }

        return json_encode($result);
    }
}