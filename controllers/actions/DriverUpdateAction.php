<?php

namespace app\controllers\actions;

use app\models\CreateUpdateDriver;
use yii\db\ActiveRecord;
use yii\rest\UpdateAction;
use yii\web\ServerErrorHttpException;

class DriverUpdateAction extends UpdateAction
{
    /**
     * Updates an existing model.
     * @param string $id the primary key of the model.
     * @return array
     * @throws ServerErrorHttpException if there is any error when updating the model
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        $requestParams = \Yii::$app->getRequest()->getBodyParams();

        $dto = new CreateUpdateDriver();
        $dto->load($requestParams, '');

        if(!$dto->validate()) {
            return ['status' => false, 'errors' => $dto->getErrors()];
        }

        /* @var $model \app\models\Driver */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load($requestParams, '');
        $model->buses = $requestParams["buses"];

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return ['status' => true, 'data' => $model];
    }

}