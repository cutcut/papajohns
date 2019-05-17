<?php

namespace app\models;

use yii\base\Model;

class CreateUpdateDriver extends Model
{
    public $name;
    public $birthday;
    public $buses;

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'birthday' => 'День рождения',
            'buses' => 'Автобусы',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'birthday', 'buses'], 'required', 'message' => 'Свойство "{attribute}" обязательно для заполнения'],
            ['name', 'string', 'max' => 100],
            ['birthday', 'date', 'format' => "php:m.d.Y"],
        ];
    }
}