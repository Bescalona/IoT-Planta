<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medicion */
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
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Medicions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'humedad_tierra',
            'humedad_aire',
            'temperatura_aire',
            'fecha',
            'mykey',
        ],
    ]) ?>

</div>
