<?
namespace app\modules\admin\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\admin\models\Notifications;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class NotificationApiController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        // Добавляем поддержку CORS
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        return $behaviors;
    }

    /**
     * Возвращает список уведомлений для текущего пользователя
     */
    public function actionList()
    {
        $userId = Yii::$app->user->id;

        if (!$userId) {
            return ['error' => 'User not authorized'];
        }

        $notifications = Notifications::find()
            ->where(['user_id' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->asArray()
            ->all();

        return $notifications;
    }

    /**
     * Инкрементирует счетчик просмотров уведомления
     */
    public function actionIncrement($id)
    {
        $notification = Notification::findOne($id);

        if (!$notification) {
            return ['error' => 'Notification not found'];
        }

        $notification->updateCounters(['views_count' => 1]);

        return ['status' => 'success'];
    }
}
