<?
namespace app\modules\admin\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\admin\models\Notifications;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\Cors;

class NotificationApiController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::class,
            'only' => ['delete'], // Только для удаления нужна авторизация
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['increment'], 
                    'roles' => ['?'],
                ],
                [
                    'allow' => true,
                    'actions' => ['list'], 
                    'roles' => ['?'], 
                ],
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:3000'], // Указываем конкретный источник
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'], // Разрешенные методы
                'Access-Control-Allow-Credentials' => true, // Разрешаем передачу куков
                'Access-Control-Allow-Headers' => ['*'], // Разрешаем все заголовки
            ],
        ];

        return $behaviors;
    }

    /**
     * Возвращает список уведомлений для текущего пользователя
     */
    public function actionList()
    {
        $userId = Yii::$app->user->id;

        /* if (!$userId) {
            return ['error' => 'User not authorized'];
        } */

        $notifications = Notifications::find()
            ->where(['user_id' => $userId])
            ->orderBy(['created_at' => SORT_ASC])
            ->asArray()
            ->all();

        return $notifications;
    }

    /**
     * Инкрементирует счетчик просмотров уведомления
     */
    public function actionIncrement($id)
    {
        if (!is_numeric($id)) {
            return ['error' => 'Invalid ID'];
        }

        $notification = Notifications::findOne($id);

        if (!$notification) {
            return ['error' => 'Notification not found'];
        }

        $notification->updateCounters(['views_count' => 1]);

        return ['status' => 'success'];
    }

    public function actionDelete($id)
    {
        if (!is_numeric($id)) {
            return ['error' => 'Invalid ID'];
        }

        $notification = Notifications::findOne($id)->delete();

        if (!$notification) {
            return ['error' => 'Notification not found'];
        }

        

        return ['status' => 'success'];
    }

}
