<?php

namespace app\commands;

use yii\console\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionCreateAdmin($username, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password); // Задаем пароль
        $user->generateAuthKey();
        
        if ($user->save()) {
            echo "Admin user '{$username}' created successfully.\n";
        } else {
            echo "Error creating admin user:\n";
            print_r($user->errors);
        }
    }
}
