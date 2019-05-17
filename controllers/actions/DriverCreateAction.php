<?php

namespace app\controllers\actions;

use app\models\CreateUpdateDriver;
use Yii;
use yii\helpers\Url;
use yii\rest\CreateAction;
use yii\web\ServerErrorHttpException;

class DriverCreateAction extends CreateAction
{
    /**
     * Creates a new model.
     * @return array
     * @throws ServerErrorHttpException if there is any error when creating the model
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $requestParams = \Yii::$app->getRequest()->getBodyParams();

        $dto = new CreateUpdateDriver();
        $dto->load($requestParams, '');

        if(!$dto->validate()) {
            return ['status' => false, 'errors' => $dto->getErrors()];
        }

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model \app\models\Driver */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load($requestParams, '');

        $model->buses = $requestParams["buses"];

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return ['status' => true, 'data' => $model];
    }

}