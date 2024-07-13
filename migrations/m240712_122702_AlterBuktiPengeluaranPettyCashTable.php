<?php

use app\models\base\BuktiPengeluaranPettyCash;
use yii\db\Migration;

/**
 * Class m240712_122702_AlterBuktiPengeluaranPettyCashTable
 */
class m240712_122702_AlterBuktiPengeluaranPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%bukti_pengeluaran_petty_cash_bill}}');
        $this->addColumn(BuktiPengeluaranPettyCash::tableName(), 'job_order_bill_id', $this->integer()->after('job_order_detail_cash_advance_id'));
        $this->createIndex(
            'idx_bukti_pengeluaran_petty_cash_3',
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_bill_id',
            true
        );
        $this->addForeignKey(
            'fk_bukti_pengeluaran_petty_cash_3',
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_bill_id',
            'job_order_bill',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_bukti_pengeluaran_petty_cash_3', BuktiPengeluaranPettyCash::tableName());
        $this->dropIndex('idx_bukti_pengeluaran_petty_cash_3', BuktiPengeluaranPettyCash::tableName());
        $this->dropColumn(BuktiPengeluaranPettyCash::tableName(), 'job_order_bill_id');
        $this->createTable('{{%bukti_pengeluaran_petty_cash_bill}}', [
            'id' => $this->primaryKey(),
            'bukti_pengeluaran_petty_cash_id' => $this->integer()->notNull(),
            'job_order_bill_id' => $this->integer(),
        ]);

        $this->createIndex('idx_bukti_pengeluaran_petty_cash_bill_1', '{{%bukti_pengeluaran_petty_cash_bill}}', 'bukti_pengeluaran_petty_cash_id', true);
        $this->createIndex('idx_bukti_pengeluaran_petty_cash_bill_2', '{{%bukti_pengeluaran_petty_cash_bill}}', 'job_order_bill_id', true);
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_bill_1', '{{%bukti_pengeluaran_petty_cash_bill}}', 'bukti_pengeluaran_petty_cash_id', 'bukti_pengeluaran_petty_cash', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_bill_2', '{{%bukti_pengeluaran_petty_cash_bill}}', 'job_order_bill_id', 'job_order_bill', 'id', 'CASCADE', 'CASCADE');
    }

}
