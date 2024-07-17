<?php

use app\models\BuktiPenerimaanPettyCash;
use app\models\BukuBank;
use yii\db\Migration;

/**
 * Class m240717_073608_AlterBuktiPenerimaanPettyCashTable
 */
class m240717_073608_AlterBuktiPenerimaanPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(BuktiPenerimaanPettyCash::tableName(),
            'buku_bank_id',
            $this->integer()->null()->after('bukti_pengeluaran_petty_cash_cash_advance_id')
        );

        $this->createIndex(
            'idx_bukti_penerimaan_petty_cash_2',
            BuktiPenerimaanPettyCash::tableName(),
            'buku_bank_id',
            true
        );

        $this->addForeignKey(
            'fk_bukti_penerimaan_petty_cash_2',
            BuktiPenerimaanPettyCash::tableName(),
            'buku_bank_id',
            BukuBank::tableName(),
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
        $this->dropForeignKey(
            'fk_bukti_penerimaan_petty_cash_2',
            BuktiPenerimaanPettyCash::tableName()
        );
        $this->dropIndex(
            'idx_bukti_penerimaan_petty_cash_2',
            BuktiPenerimaanPettyCash::tableName()
        );
        $this->dropColumn(BuktiPenerimaanPettyCash::tableName(),
            'buku_bank_id'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240717_073608_AlterBuktiPenerimaanPettyCashTable cannot be reverted.\n";

        return false;
    }
    */
}
