<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;
use app\models\ConsumoAgua;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsumoAguaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
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
$diaActual = date('Y-m-d');
echo ("Fecha Actual: ".$diaActual);
$this->title = 'Consumos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consumo-agua-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <br>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'consumo',
            'fecha',
        ],
    ]);

    $fechas = Array();
    $cons = Array();

    foreach($consumos as $consumoAgua){ 
        $fechas[] = $consumoAgua->fecha;
        $cons[] =  $consumoAgua->consumo;
    }

    echo Highcharts::widget([
        'options' => [
           'title' => ['text' => 'Consumo de Agua'],
           'xAxis' => [
              'categories' => 
               $fechas
           ],
           'yAxis' => [
              'title' => ['text' => 'cantidad']
           ],
           'series' => [
              [
                 'name' => $diaActual, 
                 'data' => $cons  //[1024,1024,1024,840,841,78,850]
              ]
           ]
        ]
     ]);   ?>
</div>