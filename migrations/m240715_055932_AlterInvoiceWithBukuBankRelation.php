<?php

use app\models\Invoice;
use yii\db\Migration;

/**
 * Class m240715_055932_AlterInvoiceWithBukuBankRelation
 */
class m240715_055932_AlterInvoiceWithBukuBankRelation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Invoice::tableName(), 'bukti_penerimaan_buku_bank_id', $this->integer());
        $this->createIndex('idx_invoice_3', Invoice::tableName(),'bukti_penerimaan_buku_bank_id');
        $this->addForeignKey('fk_invoice_3', Invoice::tableName(),'bukti_penerimaan_buku_bank_id',
            'bukti_penerimaan_buku_bank',
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
        $this->dropForeignKey('fk_invoice_3', Invoice::tableName());
        $this->dropIndex('idx_invoice_3', Invoice::tableName());
        $this->dropColumn(Invoice::tableName(), 'bukti_penerimaan_buku_bank_id');
    }

}
