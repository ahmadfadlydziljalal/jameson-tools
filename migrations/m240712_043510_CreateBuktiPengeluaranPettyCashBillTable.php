<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bukti_pengeluaran_petty_cash_bill}}`.
 */
class m240712_043510_CreateBuktiPengeluaranPettyCashBillTable extends Migration
{
    
    private string $tableName = '{{%bukti_pengeluaran_petty_cash_bill}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'bukti_pengeluaran_petty_cash_id' => $this->integer()->notNull(),
            'job_order_bill_id' => $this->integer(),
        ]);

        $this->createIndex('idx_bukti_pengeluaran_petty_cash_bill_1', $this->tableName, 'bukti_pengeluaran_petty_cash_id', true);
        $this->createIndex('idx_bukti_pengeluaran_petty_cash_bill_2', $this->tableName, 'job_order_bill_id', true);
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_bill_1', $this->tableName, 'bukti_pengeluaran_petty_cash_id', 'bukti_pengeluaran_petty_cash', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_bill_2', $this->tableName, 'job_order_bill_id', 'job_order_bill', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bukti_pengeluaran_petty_cash_bill}}');
    }
}
