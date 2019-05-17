<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property integer $avg_speed
 * @property Driver[] $drivers
 */
class Bus extends ActiveRecord
{
    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Bus',
            'avg_speed' => 'Average speed',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'avg_speed'], 'safe'],
            [['name', 'avg_speed'], 'required'],
            ['name', 'string', 'max' => 100],
            ['avg_speed', 'integer'],
        ];
    }

    public static function tableName()
    {
        return 'buses';
    }

    public function getDrivers()
    {
        return $this->hasMany(Driver::class, ['id' => 'driver_id'])->viaTable('drivers_buses', ['bus_id' => 'id']);
    }

}