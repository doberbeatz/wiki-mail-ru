<?php

namespace app\models;

use app\validators\SlugValidator;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Page
 * @package app\models
 *
 * @property integer $page_id
 * @property integer $parent_id
 * @property string  $slug
 * @property string  $title
 * @property string  $body
 * @property string  $created_at
 * @property string  $updated_at
 *
 * @property Page    $parent
 * @property Page[]  $parents
 * @property Page[]  $children
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
            [['parent_id'], 'integer'],
            [['title', 'body', 'slug'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'title'], 'string', 'max' => 55],
            [['slug'], SlugValidator::class],
            [
                ['parent_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Page::className(),
                'targetAttribute' => ['parent_id' => 'page_id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'page_id'    => 'Page ID',
            'parent_id'  => 'Parent ID',
            'slug'       => 'Slug',
            'title'      => 'Title',
            'body'       => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * @return Page
     */
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['page_id' => 'parent_id'])->one();
    }

    /**
     * @return Page[]
     */
    public function getParents()
    {
        $data = [];

        $current = $this;
        while ($current = $current->getParent()) {
            $data[] = $current;
        };

        return $data;
    }

    /**
     * @return Page[]
     */
    public function getChildren()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'page_id'])->all();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        $path = [
            $this->slug ?: $this->getOldAttribute('slug'),
        ];

        foreach ($this->getParents() as $page) {
            array_unshift($path, $page->slug);
        }

        return implode('/', $path);
    }

    /**
     * @return Breadcrumb[]
     */
    public function getBreadcrumbs()
    {
        $data = [];

        foreach ($this->getParents() as $page) {
            array_unshift($data, new Breadcrumb(
                $page->title,
                Url::to(['pages/show', 'path' => $page->getPath()])
            ));
        }

        return $data;
    }
}