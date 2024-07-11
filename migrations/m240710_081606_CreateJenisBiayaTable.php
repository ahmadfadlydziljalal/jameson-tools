<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jenis_biaya}}`.
 */
class m240710_081606_CreateJenisBiayaTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%jenis_biaya}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%jenis_biaya}}');
    }
}
