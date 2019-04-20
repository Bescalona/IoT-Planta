<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $nombre
 * @property string $contrasena
 * @property string $rol
 * @property string $fecha_registro
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_registro'], 'safe'],
            [['nombre', 'contrasena'], 'string', 'max' => 20],
            [['rol'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'contrasena' => 'Contrasena',
            'rol' => 'Rol',
            'fecha_registro' => 'Fecha Registro',
        ];
    }

    public static function findByNombre($nombre)
    {
        foreach (self::$usuarios as $usuario) {
            if (strcasecmp($usuario['nombre'], $nombre) === 0) {
                return new static($usuario);
            }
        }

        return null;
    }

    public function validateContrasena($contrasena)
    {
        return $this->contrasena === $contrasena;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function getId()
    {
        return $this->id;
    }

}
