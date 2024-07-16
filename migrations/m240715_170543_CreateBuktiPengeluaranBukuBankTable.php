<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bukti_pengeluaran_buku_bank}}`.
 */
class m240715_170543_CreateBuktiPengeluaranBukuBankTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bukti_pengeluaran_buku_bank}}', [
            'id' => $this->primaryKey(),
            'reference_number' => $this->string(50),
            'rekening_saya_id' => $this->integer(),
            'jenis_transfer_id' => $this->integer(),
            'vendor_id' => $this->integer(),
            'vendor_rekening_id' => $this->integer(),
            'nomor_bukti_transaksi' => $this->string(),
            'tanggal_transaksi' => $this->date(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);

        $this->createIndex('idx_bukti_pengeluaran_buku_bank_1', '{{%bukti_pengeluaran_buku_bank}}', 'rekening_saya_id');
        $this->createIndex('idx_bukti_pengeluaran_buku_bank_2', '{{%bukti_pengeluaran_buku_bank}}', 'jenis_transfer_id');
        $this->createIndex('idx_bukti_pengeluaran_buku_bank_3', '{{%bukti_pengeluaran_buku_bank}}', 'vendor_id');
        $this->createIndex('idx_bukti_pengeluaran_buku_bank_4', '{{%bukti_pengeluaran_buku_bank}}', 'vendor_rekening_id');

        $this->addForeignKey('fk_bukti_pengeluaran_buku_bank_1', '{{%bukti_pengeluaran_buku_bank}}', 'rekening_saya_id', 'rekening','id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_bukti_pengeluaran_buku_bank_2', '{{%bukti_pengeluaran_buku_bank}}', 'jenis_transfer_id', 'jenis_transfer','id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_bukti_pengeluaran_buku_bank_3', '{{%bukti_pengeluaran_buku_bank}}', 'vendor_id', 'card','id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_bukti_pengeluaran_buku_bank_4', '{{%bukti_pengeluaran_buku_bank}}', 'vendor_rekening_id', 'rekening','id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bukti_pengeluaran_buku_bank}}');
    }
}
