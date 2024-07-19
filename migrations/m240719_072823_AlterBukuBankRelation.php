<?php

use app\models\BuktiPenerimaanPettyCash;
use app\models\BukuBank;
use yii\db\Migration;

/**
 * Class m240719_072823_AlterBukuBankRelation
 */
class m240719_072823_AlterBukuBankRelation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->dropForeignKey(
            'fk_bukti_penerimaan_petty_cash_2',
            BuktiPenerimaanPettyCash::tableName()
        );
        $this->dropIndex(
            'idx_bukti_penerimaan_petty_cash_2',
            BuktiPenerimaanPettyCash::tableName()
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
            'RESTRICT',
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


}
