<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoic}}`.
 */
class m240713_195028_CreateInvoicTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoice}}', [
            'id' => $this->primaryKey(),
            'reference_number' => $this->string(),
            'customer_id' => $this->integer()->notNull(),
            'tanggal_invoice' => $this->date()->notNull(),
            'nomor_rekening_tagihan_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);

        $this->createIndex('idx_invoice_1', '{{%invoice}}', 'customer_id');
        $this->createIndex('idx_invoice_2', '{{%invoice}}', 'nomor_rekening_tagihan_id');

        $this->addForeignKey('fk_invoice_1', '{{%invoice}}', 'customer_id', 'card','id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_invoice_2', '{{%invoice}}', 'nomor_rekening_tagihan_id', 'rekening', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoice}}');
    }
}
