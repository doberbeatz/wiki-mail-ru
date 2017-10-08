<?php

use yii\db\Migration;

class m171008_181835_add_constraints_to_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addForeignKey(
            'fk-page-page_id',
            'pages',
            'parent_id',
            'pages',
            'page_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-page-page_id',
            'pages'
        );
    }
}
