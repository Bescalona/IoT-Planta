<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicion".
 *
 * @property int $id
 * @property int $humedad_tierra
 * @property double $humedad_aire
 * @property double $temperatura_aire
 * @property string $fecha
 * @property string $mykey+
 */
class Medicion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['humedad_tierra'], 'integer'],
            [['humedad_aire', 'temperatura_aire'], 'number'],
            [['fecha'], 'safe'],
            [['mykey'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'humedad_tierra' => 'Humedad Tierra (%)',
            'humedad_aire' => 'Humedad Aire (%RH)',
            'temperatura_aire' => 'Temperatura Aire  (°C)',
            'fecha' => 'Fecha',
            'mykey' => 'Mykey',
        ];
    }
}
