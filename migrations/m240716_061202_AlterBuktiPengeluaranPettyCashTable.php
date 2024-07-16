<?php

use app\models\BuktiPengeluaranPettyCash;
use app\models\JobOrderBill;
use yii\db\Migration;

/**
 * Class m240716_061202_AlterBuktiPengeluaranPettyCashTable
 */
class m240716_061202_AlterBuktiPengeluaranPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_bukti_pengeluaran_petty_cash_3', BuktiPengeluaranPettyCash::tableName());
        $this->dropIndex('idx_bukti_pengeluaran_petty_cash_3', BuktiPengeluaranPettyCash::tableName());
        $this->dropColumn(BuktiPengeluaranPettyCash::tableName(), 'job_order_bill_id');

        $this->addColumn(
            JobOrderBill::tableName(),
            'bukti_pengeluaran_petty_cash_id',
            $this->integer()->null()
        );
        $this->createIndex(
            'idx_job_order_bill_3',
            JobOrderBill::tableName(),
            'bukti_pengeluaran_petty_cash_id',
            true
        );
        $this->addForeignKey(
            'fk_job_order_bill_3',
            JobOrderBill::tableName(),
            'bukti_pengeluaran_petty_cash_id',
            'bukti_pengeluaran_petty_cash',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk_job_order_bill_3', JobOrderBill::tableName());
        $this->dropIndex('idx_job_order_bill_3', JobOrderBill::tableName());
        $this->dropColumn(JobOrderBill::tableName(), 'bukti_pengeluaran_petty_cash_id');


        $this->addColumn(BuktiPengeluaranPettyCash::tableName(), 'job_order_bill_id', $this->integer());
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


}
