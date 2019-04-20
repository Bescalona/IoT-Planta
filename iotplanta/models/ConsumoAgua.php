<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consumo_agua".
 *
 * @property int $id
 * @property double $consumo
 * @property string $fecha
 * @property string $mykey
 */
class ConsumoAgua extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consumo_agua';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['consumo'], 'number'],
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
            'consumo' => 'Consumo (L)',
            'fecha' => 'Fecha',
            'mykey' => 'Mykey',
        ];
    }
}
