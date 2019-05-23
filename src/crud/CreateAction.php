<?php

namespace youshu\crud;

use Yii;

class CreateAction extends Action
{
    /**
     * @var string
     */
    public $redirect;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new $this->modelClass;
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($this->redirect) {
                $redirect = $this->redirect;
            } else {
                $actions = $this->controller->actions();
                if (isset($actions['view'])) {
                    $redirect = ['view', 'id' => $model->getPrimaryKey()];
                } else {
                    $redirect = ['index'];
                }
            }

            return $this->controller->redirect($redirect);
        }

        return $this->renderHtmlResponse([
            'model' => $model,
        ]);
    }
}
