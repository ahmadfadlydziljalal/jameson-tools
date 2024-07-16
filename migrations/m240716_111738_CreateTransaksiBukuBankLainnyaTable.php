<?php

use app\models\BukuBank;
use app\models\Card;
use app\models\JenisBiaya;
use app\models\JenisPendapatan;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaksi_buku_bank_lainnya}}`.
 */
class m240716_111738_CreateTransaksiBukuBankLainnyaTable extends Migration
{

    private string $table = '{{%transaksi_buku_bank_lainnya}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {

        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'buku_bank_id' => $this->integer(),
            'card_id' => $this->integer()->notNull(),
            'jenis_pendapatan_id' => $this->integer(),
            'jenis_biaya_id' => $this->integer(),
            'nominal' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'keterangan' => $this->text(),
        ]);

        $this->createIndex('idx_transaksi_buku_bank_lainnya_1', $this->table, 'buku_bank_id', true);
        $this->createIndex('idx_transaksi_buku_bank_lainnya_2', $this->table, 'card_id');
        $this->createIndex('idx_transaksi_buku_bank_lainnya_3', $this->table, 'jenis_pendapatan_id');
        $this->createIndex('idx_transaksi_buku_bank_lainnya_4', $this->table, 'jenis_biaya_id');

        $this->addForeignKey('idx_transaksi_buku_bank_lainnya_1', $this->table, 'buku_bank_id', BukuBank::tableName(),'id','CASCADE', 'CASCADE');
        $this->addForeignKey('idx_transaksi_buku_bank_lainnya_2', $this->table, 'card_id', Card::tableName(), 'id','RESTRICT', 'CASCADE');
        $this->addForeignKey('idx_transaksi_buku_bank_lainnya_3', $this->table, 'jenis_pendapatan_id', JenisPendapatan::tableName(), 'id','RESTRICT', 'CASCADE');
        $this->addForeignKey('idx_transaksi_buku_bank_lainnya_4', $this->table, 'jenis_biaya_id', JenisBiaya::tableName(),'id','RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
