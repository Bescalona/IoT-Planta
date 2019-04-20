<?php 
namespace app\controllers;

use yii\rest\ActiveController;

class MeController extends ActiveController
{
    public $modelClass = 'app\models\Medicion'; 

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