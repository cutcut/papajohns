<?php

namespace app\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $birthday
 * @property Bus[] $buses
 */
class Driver extends ActiveRecord
{

    public function behaviors()
    {
        return [
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::class,
                'relations' => [
                    'buses',
                ],
            ],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Driver name',
            'birthday' => 'Driver birthday',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'birthday'], 'required'],
            ['name', 'string', 'max' => 100],
            ['birthday', 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * @param array $data
     * @param null $formName
     * @return bool|void
     */
    public function load($data, $formName = null) {

        if(isset($data['birthday'])) {
            $data['birthday'] = \DateTime::createFromFormat ("m.d.Y", $data['birthday'])->format("Y-m-d");
        }

        return parent::load($data, $formName);
    }

    public static function tableName()
    {
        return 'drivers';
    }

    public function getBuses()
    {
        return $this->hasMany(Bus::class, ['id' => 'bus_id'])->viaTable('drivers_buses', ['driver_id' => 'id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['age'] = function () { return (new \DateTime())->diff(new \DateTime($this->birthday))->y; };
        return $fields;
    }
}