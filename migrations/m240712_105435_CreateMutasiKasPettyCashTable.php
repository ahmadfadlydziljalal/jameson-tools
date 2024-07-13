<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mutasi_kas_petty_cash}}`.
 */
class m240712_105435_CreateMutasiKasPettyCashTable extends Migration
{

    private string $tableName = '{{%mutasi_kas_petty_cash}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'kode_voucher_id' => $this->integer()->notNull(),
            'bukti_penerimaan_petty_cash_id' => $this->integer(),
            'bukti_pengeluaran_petty_cash_id' => $this->integer(),
            'nomor' => $this->integer(),
            'nomor_voucher' => $this->string(),
            'tanggal_mutasi' => $this->date()->notNull(),
            'keterangan' => $this->text(),
        ]);

        $this->createIndex('idx_mutasi_kas_petty_cash_1', $this->tableName, 'bukti_penerimaan_petty_cash_id', true);
        $this->addForeignKey('fk_mutasi_kas_petty_cash_1', $this->tableName,
            'bukti_penerimaan_petty_cash_id',
            'bukti_penerimaan_petty_cash',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex('idx_mutasi_kas_petty_cash_2', $this->tableName, 'bukti_pengeluaran_petty_cash_id', true);
        $this->addForeignKey('fk_mutasi_kas_petty_cash_2', $this->tableName,
            'bukti_pengeluaran_petty_cash_id',
            'bukti_pengeluaran_petty_cash',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex('idx_mutasi_kas_petty_cash_3', $this->tableName, 'kode_voucher_id');
        $this->addForeignKey('fk_mutasi_kas_petty_cash_3', $this->tableName,
            'kode_voucher_id',
            'kode_voucher',
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
        $this->dropTable('{{%mutasi_kas_petty_cash}}');
    }
}
