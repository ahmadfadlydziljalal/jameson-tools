<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bukti_penerimaan_buku_bank}}`.
 */
class m240715_051812_CreateBuktiPenerimaanBukuBankTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%jenis_transfer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'alias' => $this->string(50),
        ]);

        $this->batchInsert('jenis_transfer', ['name', 'alias'], [
            ['Tunai', NULL],
            ['Transfer', NULL],
            ['Cek Giro', NULL],
        ]);

        $this->createTable('{{%bukti_penerimaan_buku_bank}}', [
            'id' => $this->primaryKey(),
            'reference_number' => $this->string(50),
            'customer_id' => $this->integer()->notNull(), # FK
            'rekening_saya_id' => $this->integer(), # FK
            'jenis_transfer_id' => $this->integer(), # FK
            'nomor_transaksi_transfer' => $this->string()->comment('Bukti setor'),
            'tanggal_transaksi_transfer' => $this->date()->comment('Tanggal setor'),
            'tanggal_jatuh_tempo' => $this->date(),
            'keterangan' => $this->text(),
            'jumlah_setor' => $this->decimal(16, 2),

            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);

        $this->createIndex('idx_bukti_penerimaan_buku_bank_1', '{{%bukti_penerimaan_buku_bank}}', 'customer_id');
        $this->createIndex('idx_bukti_penerimaan_buku_bank_2', '{{%bukti_penerimaan_buku_bank}}', 'rekening_saya_id');
        $this->createIndex('idx_bukti_penerimaan_buku_bank_3', '{{%bukti_penerimaan_buku_bank}}', 'jenis_transfer_id');

        $this->addForeignKey('fk_bukti_penerimaan_buku_bank_1', '{{%bukti_penerimaan_buku_bank}}', 'customer_id',
            'card', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_bukti_penerimaan_buku_bank_2', '{{%bukti_penerimaan_buku_bank}}', 'rekening_saya_id',
            'rekening', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_bukti_penerimaan_buku_bank_3', '{{%bukti_penerimaan_buku_bank}}', 'jenis_transfer_id',
            'jenis_transfer', 'id', 'RESTRICT', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_bukti_penerimaan_buku_bank_1', '{{%bukti_penerimaan_buku_bank}}');
        $this->dropForeignKey('fk_bukti_penerimaan_buku_bank_2', '{{%bukti_penerimaan_buku_bank}}');
        $this->dropForeignKey('fk_bukti_penerimaan_buku_bank_3', '{{%bukti_penerimaan_buku_bank}}');

        $this->dropIndex('idx_bukti_penerimaan_buku_bank_1', '{{%bukti_penerimaan_buku_bank}}');
        $this->dropIndex('idx_bukti_penerimaan_buku_bank_2', '{{%bukti_penerimaan_buku_bank}}');
        $this->dropIndex('idx_bukti_penerimaan_buku_bank_3', '{{%bukti_penerimaan_buku_bank}}');

        $this->dropTable('{{%jenis_transfer}}');
        $this->dropTable('{{%bukti_penerimaan_buku_bank}}');
    }
}
