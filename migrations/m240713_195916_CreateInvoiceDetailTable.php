<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_detail}}`.
 */
class m240713_195916_CreateInvoiceDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoice_detail}}', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer(),
            'quantity' => $this->decimal(10,2),
            'satuan_id' => $this->integer(),
            'barang_id' => $this->integer(),
            'harga' => $this->decimal(16,2),
        ]);

        $this->createIndex('idx_invoice_detail_1', '{{%invoice_detail}}', 'invoice_id');
        $this->createIndex('idx_invoice_detail_2', '{{%invoice_detail}}', 'satuan_id');
        $this->createIndex('idx_invoice_detail_3', '{{%invoice_detail}}', 'barang_id');

        $this->addForeignKey('fk_invoice_detail_1', '{{%invoice_detail}}', 'invoice_id', 'invoice', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_invoice_detail_2', '{{%invoice_detail}}', 'satuan_id', 'satuan', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_invoice_detail_3', '{{%invoice_detail}}', 'barang_id', 'barang', 'id', 'RESTRICT', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoice_detail}}');
    }
}
