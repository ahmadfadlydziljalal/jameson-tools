<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%trash}}`.
 */
class m240719_081413_CreateTrashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%trash}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'key' => $this->integer(),
            'data' => $this->json()->null(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%trash}}');
    }
}
