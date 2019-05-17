<?php

namespace app\controllers\actions;

use yii\data\ActiveDataProvider;
use yii\rest\IndexAction;

class DriverIndexAction extends IndexAction
{
    /**
     * @return ActiveDataProvider
     */
    public function run()
    {
        $activeDataProvider = parent::run();

        $activeDataProvider->setSort(['defaultOrder' => ['name' => SORT_ASC]]);

        return $activeDataProvider;
    }

}