<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_method}}`.
 */
class m240714_232044_CreatePaymentMethodTable extends Migration
{
    private $tableName = '{{%payment_method}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_method}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'alias' => $this->string()->notNull()->unique(),
            'code' => $this->tinyInteger(8)->notNull()->unique(),
        ]);

        $this->batchInsert($this->tableName, ['name', 'alias', 'code'], [
            ['Cash', 'TUNAI' , 10],
            ['Debet' , 'DEBET' , 20],
            ['Card', 'CARD', 30],
            ['Q-RIS', 'Q-RIS', 40],
            ['Transfer Bank', 'TRANSFER', 50],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_method}}');
    }
}
