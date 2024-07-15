<?php

use app\models\SetoranKasir;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%bukti_penerimaan_buku_bank_setoran_kasir}}`.
 */
class m240715_054346_CreateBuktiPenerimaanBukuBankSetoranKasirTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(SetoranKasir::tableName(),'bukti_penerimaan_buku_bank_id', $this->integer()->null());
        $this->createIndex('idx_setoran_kasir_2', 'setoran_kasir', 'bukti_penerimaan_buku_bank_id');
        $this->addForeignKey('fk_setoran_kasir_2', 'setoran_kasir', 'bukti_penerimaan_buku_bank_id',
            'bukti_penerimaan_buku_bank', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_setoran_kasir_2', 'setoran_kasir');
        $this->dropIndex('idx_setoran_kasir_2', 'setoran_kasir');
        $this->dropColumn(SetoranKasir::tableName(),'bukti_penerimaan_buku_bank_id');
    }
}
