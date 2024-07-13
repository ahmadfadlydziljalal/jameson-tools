<?php

use app\models\BuktiPenerimaanPettyCash;
use app\models\BuktiPengeluaranPettyCash;
use yii\db\Migration;

/**
 * Class m240712_125712_AlterBuktiPenerimaanPettyCashTable
 */
class m240712_125712_AlterBuktiPenerimaanPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(BuktiPenerimaanPettyCash::tableName(), 'bukti_pengeluaran_petty_cash_cash_advance_id', $this->integer()->null()->after('reference_number'));
        $this->createIndex('idx_bukti_penerimaan_petty_cash_1', BuktiPenerimaanPettyCash::tableName(), 'bukti_pengeluaran_petty_cash_cash_advance_id', true);
        $this->addForeignKey('fk_bukti_penerimaan_petty_cash_1', BuktiPenerimaanPettyCash::tableName(), 'bukti_pengeluaran_petty_cash_cash_advance_id',
            'bukti_pengeluaran_petty_cash',
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
        $this->dropForeignKey('fk_bukti_penerimaan_petty_cash_1', BuktiPenerimaanPettyCash::tableName());
        $this->dropIndex('idx_bukti_penerimaan_petty_cash_1', BuktiPenerimaanPettyCash::tableName());
        $this->dropColumn(BuktiPenerimaanPettyCash::tableName(), 'bukti_pengeluaran_petty_cash_cash_advance_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240712_125712_AlterBuktiPenerimaanPettyCashTable cannot be reverted.\n";

        return false;
    }
    */
}
