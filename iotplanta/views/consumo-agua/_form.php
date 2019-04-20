<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
if(Yii::$app->user->isGuest){
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
          $uri = 'https://';
      } else {
          $uri = 'http://';
      }
      $uri .= $_SERVER['HTTP_HOST'];
      header('Location: '.$uri.'/iotplanta/web/index.php/site/login');
      exit; 
}

/* @var $this yii\web\View */
/* @var $model app\models\ConsumoAgua */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consumo-agua-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'consumo')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'mykey')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
