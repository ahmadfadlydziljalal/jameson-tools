<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bukti_penerimaan_petty_cash_cash_advance}}`.
 */
class m240712_082256_CreateBuktiPenerimaanPettyCashCashAdvanceTable extends Migration
{

    private string $table = '{{%bukti_penerimaan_petty_cash_cash_advance}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'bukti_penerimaan_petty_cash_id' => $this->integer(),
            'bukti_pengeluaran_petty_cash_cash_advance_id' => $this->integer(),
        ]);

        $this->createIndex('idx_bukti_penerimaan_petty_cash_cash_advance_1', $this->table, 'bukti_penerimaan_petty_cash_id', true);
        $this->createIndex('idx_bukti_penerimaan_petty_cash_cash_advance_2', $this->table, 'bukti_pengeluaran_petty_cash_cash_advance_id', true);

        $this->addForeignKey('fk_bukti_penerimaan_petty_cash_cash_advance_1', $this->table, 'bukti_penerimaan_petty_cash_id',
            'bukti_penerimaan_petty_cash',
            'id',
            'CASCADE',
            'CASCADE',
        );
        $this->addForeignKey('fk_bukti_penerimaan_petty_cash_cash_advance_2', $this->table, 'bukti_pengeluaran_petty_cash_cash_advance_id',
            'bukti_pengeluaran_petty_cash_cash_advance',
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
        $this->dropTable('{{%bukti_penerimaan_petty_cash_cash_advance}}');
    }
}
