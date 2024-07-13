<?php

use app\models\BuktiPenerimaanPettyCash;
use yii\db\Migration;

/**
 * Class m240713_192440_AlterBuktiPenerimaanPettyCashTable
 */
class m240713_192440_AlterBuktiPenerimaanPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_bukti_penerimaan_petty_cash_1', BuktiPenerimaanPettyCash::tableName());
        $this->dropIndex('idx_bukti_penerimaan_petty_cash_1', BuktiPenerimaanPettyCash::tableName());

        $this->createIndex('idx_bukti_penerimaan_petty_cash_1', BuktiPenerimaanPettyCash::tableName(), 'bukti_pengeluaran_petty_cash_cash_advance_id', true);
        $this->addForeignKey('fk_bukti_penerimaan_petty_cash_1', BuktiPenerimaanPettyCash::tableName(), 'bukti_pengeluaran_petty_cash_cash_advance_id',
            'bukti_pengeluaran_petty_cash',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      return true;
    }


}
