<?php

namespace youshu\data;

use Iterator;
use Yii;

class ActiveDataProvider extends \yii\data\ActiveDataProvider implements Iterator
{
    private $_models;
    private $_total;
    private $_position;
    private $_pagination;

    public function current()
    {
        return $this->_models[$this->_position];
    }

    public function key()
    {
        return $this->_position;
    }

    public function next()
    {
        $this->_position += 1;
    }

    public function rewind()
    {
        if (is_null($this->_models)) {
            $this->_models = $this->getModels();
            $this->_total  = count($this->_models);
        }

        $this->_position = 0;
    }

    public function valid()
    {
        return $this->_position < $this->_total;
    }

    public function limit($limit)
    {
        $this->pagination->pageSize = $limit;
        return $this;
    }

    public function toArray(array $fields = null)
    {
        $data = [];

        foreach ($this->getModels() as $model) {
            $data[] = $model->toArray($fields);
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getPagination()
    {
        if ($this->_pagination === null) {
            $this->setPagination([]);
        }

        return $this->_pagination;
    }

    /**
     * @inheritdoc
     */
    public function setPagination($value)
    {
        if (is_array($value)) {
            $config = ['class' => Pagination::className()];
            if ($this->id !== null) {
                $config['pageParam'] = $this->id . '-page';
                $config['pageSizeParam'] = $this->id . '-per-page';
            }
            $this->_pagination = Yii::createObject(array_merge($config, $value));
        } elseif ($value instanceof Pagination || $value === false) {
            $this->_pagination = $value;
        } else {
            throw new InvalidArgumentException('Only Pagination instance, configuration array or false is allowed.');
        }
    }
}
