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
/* @var $model app\models\MedicionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'humedad_tierra') ?>

    <?= $form->field($model, 'humedad_aire') ?>

    <?= $form->field($model, 'temperatura_aire') ?>

    <?= $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'mykey') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
