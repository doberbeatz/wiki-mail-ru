<?php

use yii\db\Migration;

class m171008_213409_add_unique_index extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createIndex(
            'unique-parent_slug-idx',
            'pages',
            ['parent_id', 'slug']
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'unique-parent_slug-idx',
            'pages'
        );
    }
}
