<?php

use app\models\base\MutasiKasPettyCash;
use app\models\Card;
use app\models\JenisBiaya;
use app\models\JenisPendapatan;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaksi_mutasi_kas_petty_cash_lainnya}}`.
 */
class m240713_151619_CreateTransaksiMutasiKasPettyCashLainnyaTable extends Migration
{
    private string $table = '{{%transaksi_mutasi_kas_petty_cash_lainnya}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'mutasi_kas_petty_cash_id' => $this->integer(),
            'card_id' => $this->integer()->notNull(),
            'jenis_pendapatan_id' => $this->integer(),
            'jenis_biaya_id' => $this->integer(),
            'nominal' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'keterangan' => $this->text(),
        ]);

        $this->createIndex('idx_transaksi_mutasi_kas_petty_cash_lainnya_1', $this->table, 'mutasi_kas_petty_cash_id', true);
        $this->createIndex('idx_transaksi_mutasi_kas_petty_cash_lainnya_2', $this->table, 'card_id');
        $this->createIndex('idx_transaksi_mutasi_kas_petty_cash_lainnya_3', $this->table, 'jenis_pendapatan_id');
        $this->createIndex('idx_transaksi_mutasi_kas_petty_cash_lainnya_4', $this->table, 'jenis_biaya_id');

        $this->addForeignKey('idx_transaksi_mutasi_kas_petty_cash_lainnya_1', $this->table, 'mutasi_kas_petty_cash_id', MutasiKasPettyCash::tableName(),'id','CASCADE', 'CASCADE');
        $this->addForeignKey('idx_transaksi_mutasi_kas_petty_cash_lainnya_2', $this->table, 'card_id', Card::tableName(), 'id','RESTRICT', 'CASCADE');
        $this->addForeignKey('idx_transaksi_mutasi_kas_petty_cash_lainnya_3', $this->table, 'jenis_pendapatan_id', JenisPendapatan::tableName(), 'id','RESTRICT', 'CASCADE');
        $this->addForeignKey('idx_transaksi_mutasi_kas_petty_cash_lainnya_4', $this->table, 'jenis_biaya_id', JenisBiaya::tableName(),'id','RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%transaksi_mutasi_kas_petty_cash_lainnya}}');
    }
}
