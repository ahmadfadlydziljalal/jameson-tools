<?php

use app\models\BuktiPengeluaranPettyCash;
use yii\db\Migration;

/**
 * Class m240715_171907_AlterJobOrderDetailCashAdvanceTable
 */
class m240715_171907_AlterJobOrderDetailCashAdvanceTable extends Migration
{

    private string $tableName = 'job_order_detail_cash_advance';
    private array $columns = [];

    public function init()
    {
        parent::init();
        $this->columns = [
            ['bukti_pengeluaran_petty_cash_id', $this->integer()],
            ['bukti_pengeluaran_buku_bank_id', $this->integer()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->columns as $column) {
            $this->addColumn($this->tableName, $column[0], $column[1]);
        }
        $this->createIndex('idx_bukti_pengeluaran_petty_cash_5', $this->tableName, 'bukti_pengeluaran_petty_cash_id', true);
        $this->createIndex('idx_bukti_pengeluaran_petty_cash_6', $this->tableName, 'bukti_pengeluaran_buku_bank_id', false);

        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_5', $this->tableName, 'bukti_pengeluaran_petty_cash_id', BuktiPengeluaranPettyCash::tableName(), 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_6', $this->tableName, 'bukti_pengeluaran_buku_bank_id', 'bukti_pengeluaran_buku_bank', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_bukti_pengeluaran_petty_cash_5', $this->tableName);
        $this->dropForeignKey('fk_bukti_pengeluaran_petty_cash_6', $this->tableName);

        $this->dropIndex('idx_bukti_pengeluaran_petty_cash_5', $this->tableName);
        $this->dropIndex('idx_bukti_pengeluaran_petty_cash_6', $this->tableName);
        foreach ($this->columns as $column) {
            $this->dropColumn($this->tableName, $column[0]);
        }
    }

}
