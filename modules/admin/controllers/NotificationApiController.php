<?
namespace app\modules\admin\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\admin\models\Notifications;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\AccessControl;

class NotificationApiController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:3000'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                'Access-Control-Allow-Headers' => ['*'],
            ],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['list', 'increment'],
                    'roles' => ['?', '@'],
                ],
                [
                    'allow' => false,
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

        return $behaviors;
    }

    /**
     * Возвращает список уведомлений для текущего пользователя
     */
    public function actionList()
    {
        //На будущее для показа конкретным юзерам
        //$userId = Yii::$app->user->id;

        $notifications = Notifications::find()
            //->where(['user_id' => $userId])
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
