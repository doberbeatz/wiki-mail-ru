<?php

namespace app\validators;

use app\models\Page;
use yii\validators\Validator;

class SlugValidator extends Validator
{
    /**
     * @param Page $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $page = Page::find()
            ->bySlug($model->slug)
            ->byParentId($model->parent_id)
            ->one();

        if ($page && ($page->page_id != $model->page_id)) {
            $this->addError(
                $model,
                $attribute,
                'Slug exists in this level, please choose another one.'
            );
        }
    }
}