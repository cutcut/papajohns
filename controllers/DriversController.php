<?php

namespace app\controllers;

use yii\data\SqlDataProvider;
use yii\rest\ActiveController;

class DriversController extends ActiveController
{
    public $modelClass = 'app\models\Driver';

    public function actions()
    {
        $actions = parent::actions();

        $actions['index'] = [
            'class' => 'app\controllers\actions\DriverIndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['create'] = [
            'class' => 'app\controllers\actions\DriverCreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $actions['update'] = [
            'class' => 'app\controllers\actions\DriverUpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->updateScenario,
        ];

        return $actions;
    }

    /**
     * @param $cityA
     * @param $cityB
     * @return int
     */
    public function getDistance($cityA, $cityB): int
    {
        return 240;
    }

    /**
     * @param $id
     * @return SqlDataProvider
     */
    public function actionTop($cityA, $cityB, $id = null): SqlDataProvider
    {

        $distance = $this->getDistance($cityA, $cityB);
        $query = (new \yii\db\Query())
            ->from('buses AS b')
            ->innerJoin('drivers_buses AS db', 'b.id = db.bus_id');

        if ($id !== null) {
            $query->where(['db.driver_id' => $id]);
        }

        $count = clone $query;

        $query->select([
            'd.*',
            'b.avg_speed',
            'YEAR(NOW()) - YEAR(d.birthday) - (DATE_FORMAT(NOW(), \'%m%d\') < DATE_FORMAT(d.birthday, \'%m%d\')) AS age',
            'CEIL(' . $distance / 8 . ' / b.avg_speed) AS travel_time'
        ])
            ->innerJoin('drivers AS d', 'd.id = db.driver_id')
            ->orderBy('b.avg_speed');

        return new SqlDataProvider([
            'sql' => $query->createCommand()->getRawSql(),
            'totalCount' => $count->count(),
            'pagination' => [
                'defaultPageSize' => 10,
            ],
        ]);
    }

}