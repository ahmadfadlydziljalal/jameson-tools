<?php

use app\models\BuktiPengeluaranBukuBank;
use app\models\Card;
use app\models\JenisBiaya;
use app\models\JobOrder;
use app\models\MataUang;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%job_order_detail_petty_cash}}`.
 */
class m240718_010250_CreateJobOrderDetailPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%job_order_detail_petty_cash}}', [
            'id' => $this->primaryKey(),
            'job_order_id' => $this->integer(),
            'vendor_id' => $this->integer()->notNull(),
            'jenis_biaya_id'=> $this->integer()->notNull(),
            'mata_uang_id'=> $this->integer()->notNull(),
            'nominal' => $this->decimal(12,2)->notNull(),
            'bukti_pengeluaran_buku_bank_id'=> $this->integer()
        ]);

        $this->createIndex('idx_job_order_detail_petty_cash_id_1', '{{%job_order_detail_petty_cash}}', 'job_order_id', true);
        $this->createIndex('idx_job_order_detail_petty_cash_id_2', '{{%job_order_detail_petty_cash}}', 'vendor_id');
        $this->createIndex('idx_job_order_detail_petty_cash_id_3', '{{%job_order_detail_petty_cash}}', 'jenis_biaya_id');
        $this->createIndex('idx_job_order_detail_petty_cash_id_4', '{{%job_order_detail_petty_cash}}', 'mata_uang_id');
        $this->createIndex('idx_job_order_detail_petty_cash_id_5', '{{%job_order_detail_petty_cash}}', 'bukti_pengeluaran_buku_bank_id', true);

        $this->addForeignKey('fk_job_order_detail_petty_cash_id_1', '{{%job_order_detail_petty_cash}}', 'job_order_id', JobOrder::tableName(),'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_job_order_detail_petty_cash_id_2', '{{%job_order_detail_petty_cash}}', 'vendor_id', Card::tableName(),'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_job_order_detail_petty_cash_id_3', '{{%job_order_detail_petty_cash}}', 'jenis_biaya_id', JenisBiaya::tableName(),'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_job_order_detail_petty_cash_id_4', '{{%job_order_detail_petty_cash}}', 'mata_uang_id', MataUang::tableName(),'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_job_order_detail_petty_cash_id_5', '{{%job_order_detail_petty_cash}}', 'bukti_pengeluaran_buku_bank_id', BuktiPengeluaranBukuBank::tableName(),'id', 'SET NULL', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%job_order_detail_petty_cash}}');
    }
}
