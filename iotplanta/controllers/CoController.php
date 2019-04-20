<?php 
namespace app\controllers;

use yii\rest\ActiveController;

class CoController extends ActiveController
{
    public $modelClass = 'app\models\ConsumoAgua'; 

    protected function verbs()
{
    return [
        'index' => ['GET', 'HEAD'],
        'view' => ['GET', 'HEAD'],
        'create' => ['POST','PUT'],
        'update' => ['PUT', 'PATCH'],
        'delete' => ['DELETE'],
    ];
}
}

 ?>