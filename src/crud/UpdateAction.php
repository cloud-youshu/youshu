<?php

namespace youshu\crud;

use Yii;

class UpdateAction extends Action
{
    /**
     * @var string
     */
    public $param = 'id';
    /**
     * @var string
     */
    public $redirect;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $id = Yii::$app->request->get($this->param);


        $model = $this->findModel($id);

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