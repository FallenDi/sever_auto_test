<?php
namespace app\modules\admin;

use yii\base\Module;
use Yii;

class AdminModule extends Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();
        // Дополнительная инициализация для модуля
    }
}
