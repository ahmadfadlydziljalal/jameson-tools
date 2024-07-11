<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bukti_pengeluaran_petty_cash_cash_advance}}`.
 */
class m240712_025555_CreateBuktiPengeluaranPettyCashCashAdvanceTable extends Migration
{

    private string $tableName = '{{%bukti_pengeluaran_petty_cash_cash_advance}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'bukti_pengeluaran_petty_cash_id' => $this->integer()->notNull(),
            'job_order_detail_cash_advance_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_bukti_pengeluaran_petty_cash_cash_advance_1', $this->tableName, 'bukti_pengeluaran_petty_cash_id', true);
        $this->createIndex('idx_bukti_pengeluaran_petty_cash_cash_advance_2', $this->tableName, 'job_order_detail_cash_advance_id', true);
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_cash_advance_1', $this->tableName, 'bukti_pengeluaran_petty_cash_id', 'bukti_pengeluaran_petty_cash', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_cash_advance_2', $this->tableName, 'job_order_detail_cash_advance_id', 'job_order_detail_cash_advance', 'id', 'CASCADE', 'CASCADE',);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable($this->tableName);
    }
}
