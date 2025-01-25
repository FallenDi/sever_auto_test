<?php
namespace app\modules\admin;

use yii\base\Module;
use Yii;

class AdminModule extends Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $defaultRoute = 'auth/login'; // Устанавливаем маршрут по умолчанию

    public function init()
    {
        parent::init();
        // Дополнительная инициализация для модуля
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'], // Разрешаем доступ к странице логина
                        'roles' => ['?'], // Для гостей
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'], // Для авторизованных пользователей
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    Yii::$app->response->redirect(['/admin/auth/login'])->send();
                    return false;
                },
            ],
        ];
    }
}
