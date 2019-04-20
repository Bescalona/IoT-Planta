<?php

use yii\helpers\Html;
use yii\grid\GridView;

use miloschuman\highcharts\Highcharts;
use app\models\Medicion;

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

$fechas = Array();
$humedades = Array();
$temperaturas =Array();
$hums = Array();

foreach($mediciones as $medicion){ 
    $fechas[] = $medicion->fecha;
    $humedades[]=$medicion->humedad_tierra;
    $temperaturas[]= $medicion->temperatura_aire;
    $hums[] =  $medicion->humedad_aire;
}

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
echo ("Fecha Actual: ".$diaActual);
$this->title = 'Mediciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
     <script> 
     function enviarAjax($id){

        $.ajax({
          url: "192.168.88.63",
          type : 'GET', 
          data:$id, 
          dataType: "json", 
          success: function(respuesta) {
              $("#titulo_edit").val(respuesta.titulo);
              $("#valor_edit").val(respuesta.valor);
              $("#descripcion_edit").val(respuesta.descripcion);
              document.formEdit.action = "cuota/"+$id;
          },
          error: function() {
              console.log("No se ha podido obtener la información");
          }
        });
    }     
    
</script> 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <br>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'humedad_tierra',
            'humedad_aire',
            'temperatura_aire',
            'fecha',
            //'mykey',
        ],
    ]); 
    echo Highcharts::widget([
        'options' => [
           'title' => ['text' => 'Humedad del suelo del dia'],
           'xAxis' => [
              'categories' => 
               $fechas  //['00:00:00', '13:32:26', '13:44:01','16:47:25','16:49:15','16:49:56','16:54:48']
           ],
           'yAxis' => [
              'title' => ['text' => 'humedad']
           ],
           'series' => [
              [
                 'name' => $diaActual, 
                 'data' => $humedades  //[1024,1024,1024,840,841,78,850]
              ]
           ]
        ]
     ]);

     echo Highcharts::widget([
        'options' => [
           'title' => ['text' => 'Humedad del aire del dia'],
           'xAxis' => [
              'categories' => 
               $fechas  //['00:00:00', '13:32:26', '13:44:01','16:47:25','16:49:15','16:49:56','16:54:48']
           ],
           'yAxis' => [
              'title' => ['text' => 'humedad']
           ],
           'series' => [
              [
                 'name' => $diaActual, 
                 'data' => $hums  //[1024,1024,1024,840,841,78,850]
              ]
           ]
        ]
     ]);

     echo Highcharts::widget([
        'options' => [
           'title' => ['text' => 'Temperatura del dia'],
           'xAxis' => [
              'categories' => 
               $fechas  //['00:00:00', '13:32:26', '13:44:01','16:47:25','16:49:15','16:49:56','16:54:48']
           ],
           'yAxis' => [
              'title' => ['text' => '°C']
           ],
           'series' => [
              [
                 'name' => $diaActual, 
                 'data' => $temperaturas  //[1024,1024,1024,840,841,78,850]
              ]
           ]
        ]
     ]);
    ?>
</div>





    
    
