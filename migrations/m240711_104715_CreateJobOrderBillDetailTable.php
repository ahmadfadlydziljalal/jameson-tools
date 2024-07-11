<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%job_order_bill_detail}}`.
 */
class m240711_104715_CreateJobOrderBillDetailTable extends Migration
{

    private string $table = '{{%job_order_bill_detail}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'job_order_bill_id' => $this->integer(),
            'quantity' => $this->decimal(8,2)->notNull(),
            'satuan_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->notNull(),
            'price' => $this->decimal(16,2)->notNull()
        ]);
        $this->createIndex('idx_job_order_bill_detail_1', $this->table, 'job_order_bill_id');
        $this->createIndex('idx_job_order_bill_detail_2', $this->table, 'satuan_id');
        $this->addForeignKey('fk_job_order_bill_detail_1', $this->table, 'job_order_bill_id',
            'job_order_bill',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('fk_job_order_bill_detail_2', $this->table, 'satuan_id',
            'satuan',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%job_order_bill_detail}}');
    }
}
