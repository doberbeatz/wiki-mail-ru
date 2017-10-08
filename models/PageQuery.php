<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * Class PageQuery
 * @package app\models
 * @see Page
 */
class PageQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->modelClass = Page::class;
    }

    /**
     * @param $pageId
     * @return $this
     */
    public function byId($pageId)
    {
        return $this->andWhere(['page_id' => $pageId]);
    }

    /**
     * @param null $parentId
     * @return $this
     */
    public function byParentId($parentId = null)
    {
        return $this->andWhere(['parent_id' => $parentId]);
    }

    /**
     * @param $slug
     * @return $this
     */
    public function bySlug($slug)
    {
        return $this->andWhere(['slug' => $slug]);
    }

    /**
     * @param null $path
     * @return $this
     */
    public function byPath($path = null)
    {
        $pageId = null;

        if (!is_null($path)) {
            foreach (explode('/', $path) as $slug) {
                $page = Page::find()
                    ->bySlug($slug)
                    ->byParentId($pageId)
                    ->one();
                $pageId = $page->page_id;
            }
        }

        return $this->byId($pageId);
    }
}