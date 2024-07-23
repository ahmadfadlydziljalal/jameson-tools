<?php

use app\models\Card;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%petty_cash}}`.
 */
class m240723_070348_CreatePettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%petty_cash}}', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer()->notNull(),
            'saldo_awal' => $this->decimal(12,2)->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->string(10)->null()->defaultValue(null),
            'updated_by' => $this->string(10)->null()->defaultValue(null),
        ]);

        $this->createIndex('idx_petty_cash_1', '{{%petty_cash}}', 'card_id', true);
        $this->addForeignKey('fk_petty_cash_1', '{{%petty_cash}}', 'card_id',
            Card::tableName(),
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%petty_cash}}');
    }
}
