<?php

namespace app\controllers;

use app\models\Notification;
use Yii;
use app\models\User;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends \yii\rest\Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBasicAuth::class,
                'auth' => function ($username, $password) {
                    return User::findOne(['username' => $username, 'password' => $password]);
                },
            ],
        ];
    }

    public function actionIndex()
    {
        return Notification::find()->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function actionView($id)
    {
        return Notification::findOne($id);
    }

    public function actionCreate()
    {
        $model = new Notification();
        $model->load(Yii::$app->request->post(), '');
        if ($model->save()) {
            return $model;
        }
        return ['error' => 'Failed to create notification'];
    }

    public function actionUpdate($id)
    {
        $model = Notification::findOne($id);
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $model;
        }
        return ['error' => 'Failed to update notification'];
    }

    public function actionDelete($id)
    {
        if (Notification::findOne($id)->delete()) {
            return ['success' => true];
        }
        return ['error' => 'Failed to delete notification'];
    }
}
