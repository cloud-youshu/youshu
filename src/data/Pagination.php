<?php

namespace youshu\data;

use Yii;

/**
 * 分页
 */
class Pagination extends \yii\data\Pagination
{
    /**
     * @var string name of the parameter storing the current page index.
     */
    public $pageParam = 'page_num';
    /**
     * @var string name of the parameter storing the page size.
     */
    public $pageSizeParam = 'page_size';
    /**
     * @var int the default page size. This property will be returned by [[pageSize]] when page size
     * cannot be determined by [[pageSizeParam]] from [[params]].
     */
    public $defaultPageSize = 10;

    /**
     * @inheritdoc
     */
    public function getPage($recalculate = false)
    {
        return parent::getPage() + 1;
    }

    /**
     * @inheritdoc
     */
    public function getOffset()
    {
        $pageSize = $this->getPageSize();

        return $pageSize < 1 ? 0 : ($this->getPage() - 1) * $pageSize;
    }
}
