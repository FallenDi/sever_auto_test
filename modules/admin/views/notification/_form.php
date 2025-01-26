<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\Notifications $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="notifications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <label><?= Html::encode($model->getAttributeLabel('views_count')) ?></label>
        <p><?= Html::encode($model->views_count) ?></p>
    </div>

    <div class="form-group">
        <label><?= Html::encode($model->getAttributeLabel('created_at')) ?></label>
        <p><?= Html::encode($model->created_at) ?></p>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
