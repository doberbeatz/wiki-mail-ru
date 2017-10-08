<?php

namespace app\models;

use app\validators\SlugValidator;
use yii\db\ActiveRecord;

/**
 * Class Page
 * @package app\models
 *
 * @property int $page_id
 * @property int $parent_id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property int $created_at
 * @property int $updated_at
 */
class Page extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    public function init()
    {
        parent::init();
        $this->title = '';
        $this->slug = '';
        $this->body = '';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'body', 'slug'], 'required'],
            ['title', 'string', 'length' => [0, 55]],
            ['body', 'string'],
            ['slug', SlugValidator::class],
            ['slug', 'string', 'length' => [0, 255]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title of page',
            'body'  => 'Content',
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    /**
     * @return self|null
     */
    public function getParent()
    {
        if ($this->parent_id) {
            return self::find()->byId($this->parent_id)->one();
        }

        return null;
    }

    /**
     * @return $this
     */
    public function getChildren()
    {
        return self::find()->byParentId($this->page_id)->all();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        $path = [
            $this->slug ?: $this->getOldAttribute('slug'),
        ];
        $current = $this;

        while ($current = $current->getParent()) {
            array_unshift($path, $current->slug);
        };

        return implode('/', $path);
    }
}