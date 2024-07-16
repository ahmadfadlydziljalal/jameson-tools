<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%buku_bank}}`.
 */
class m240716_093948_CreateBukuBankTable extends Migration
{

    private string $tableName = '{{%buku_bank}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%buku_bank}}', [
            'id' => $this->primaryKey(),
            'kode_voucher_id' => $this->integer()->notNull(),
            'bukti_penerimaan_buku_bank_id' => $this->integer(),
            'bukti_pengeluaran_buku_bank_id' => $this->integer(),
            'nomor_voucher' => $this->string(),
            'tanggal_transaksi' => $this->date()->notNull(),
            'keterangan' => $this->text(),
        ]);

        # Kode voucher
        $this->createIndex(
            'idx_buku_bank_1',
            $this->tableName,
            'kode_voucher_id'
        );
        $this->addForeignKey(
            'fk_buku_bank_1',
            $this->tableName,
            'kode_voucher_id',
            'kode_voucher',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        # Bukti penerimaan buku bank
        $this->createIndex(
            'idx_buku_bank_2',
            $this->tableName,
            'bukti_penerimaan_buku_bank_id',
            true
        );
        $this->addForeignKey(
            'fk_buku_bank_2',
            $this->tableName,
            'bukti_penerimaan_buku_bank_id',
            'bukti_penerimaan_buku_bank',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        # Bukti pengeluaran buku bank
        $this->createIndex(
            'idx_buku_bank_3',
            $this->tableName,
            'bukti_pengeluaran_buku_bank_id',
            true
        );
        $this->addForeignKey(
            'fk_buku_bank_3',
            $this->tableName,
            'bukti_pengeluaran_buku_bank_id',
            'bukti_pengeluaran_buku_bank',
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
        $this->dropTable('{{%buku_bank}}');
    }
}
