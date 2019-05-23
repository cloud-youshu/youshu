<?php

namespace youshu\db;

use Yii;

class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $model = new $this->modelClass;
        
        $softDeleteBehavior = $model->getBehavior('softDelete');
        if ($softDeleteBehavior) {
            $this->andOnCondition([$softDeleteBehavior->deletedAtAttribute => 0]);
        }
    }
}
