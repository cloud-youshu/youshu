<?php

namespace youshu\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use youshu\behaviors\SoftDeleteBehavior;

/**
 * AR基类
 *
 * @since 1.0
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        //是否需要软删除
        if (isset(static::getTableSchema()->columns['deleted_at'])) {
            return [
                // 时间戳
                'timestamp' => [
                    'class' => TimestampBehavior::className()
                ],
                // 软删除
                'softDelete' => [
                    'class' => SoftDeleteBehavior::className()
                ],
            ];
        }
        
        return [
            // 时间戳
            'timestamp' => [
                'class' => TimestampBehavior::className()
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * 查找或抛出异常
     */
    public static function findOrFail($condition)
    {
        if (($model = static::findOne($condition)) !== null) {
            return $model;
        }

        throw new NotFoundException('查找的模型不存在');
    }
}
