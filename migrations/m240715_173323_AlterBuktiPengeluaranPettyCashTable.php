<?php

use app\models\BuktiPengeluaranPettyCash;
use yii\db\Migration;

/**
 * Class m240715_173323_AlterBuktiPengeluaranPettyCashTable
 */
class m240715_173323_AlterBuktiPengeluaranPettyCashTable extends Migration
{
    /**
     * fk_bukti_pengeluaran_petty_cash_2
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropForeignKey(
            'fk_bukti_pengeluaran_petty_cash_2',
            BuktiPengeluaranPettyCash::tableName()
        );
        $this->dropIndex(
            'idx_bukti_pengeluaran_petty_cash_2',
            BuktiPengeluaranPettyCash::tableName()
        );
        $this->dropColumn(
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_detail_cash_advance_id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn(
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_detail_cash_advance_id',
            $this->integer()->after('reference_number')
        );
        $this->createIndex(
            'idx_bukti_pengeluaran_petty_cash_2',
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_detail_cash_advance_id',
            true
        );
        $this->addForeignKey(
            'fk_bukti_pengeluaran_petty_cash_2',
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_detail_cash_advance_id',
            'job_order_detail_cash_advance',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240715_173323_AlterBuktiPengeluaranPettyCashTable cannot be reverted.\n";

        return false;
    }
    */
}
