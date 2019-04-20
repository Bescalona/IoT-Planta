<?php

use yii\helpers\Html;
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
/* @var $model app\models\Medicion */

$this->title = 'Create Medicion';
$this->params['breadcrumbs'][] = ['label' => 'Medicions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
