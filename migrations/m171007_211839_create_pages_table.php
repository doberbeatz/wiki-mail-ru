<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pages`.
 */
class m171007_211839_create_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(
            'pages',
            [
                'page_id'    => $this->primaryKey(),
                'parent_id'  => $this->integer(),
                'slug'       => $this->string(55),
                'title'      => $this->string(55)->notNull(),
                'body'       => $this->text()->notNull(),
                'created_at' => $this->timestamp(),
                'updated_at' => $this->timestamp()->defaultValue(null),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('pages');
    }
}
