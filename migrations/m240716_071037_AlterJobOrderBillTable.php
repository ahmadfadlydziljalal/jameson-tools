<?php

use app\models\BuktiPengeluaranBukuBank;
use app\models\JobOrderBill;
use yii\db\Migration;

/**
 * Class m240716_071037_AlterJobOrderBillTable
 */
class m240716_071037_AlterJobOrderBillTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(JobOrderBill::tableName(), 'bukti_pengeluaran_buku_bank_id', $this->integer()->null());
        $this->createIndex('idx_job_order_bill_4', JobOrderBill::tableName(), 'bukti_pengeluaran_buku_bank_id');
        $this->addForeignKey('fk_job_order_bill_4', JobOrderBill::tableName(), 'bukti_pengeluaran_buku_bank_id',
            BuktiPengeluaranBukuBank::tableName(),
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
        $this->dropForeignKey('fk_job_order_bill_4', JobOrderBill::tableName());
        $this->dropIndex('idx_job_order_bill_4', JobOrderBill::tableName());
        $this->dropColumn(JobOrderBill::tableName(), 'bukti_pengeluaran_buku_bank_id');
    }


}
