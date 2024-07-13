<?php

use app\models\base\BuktiPengeluaranPettyCash;
use yii\db\Migration;

/**
 * Class m240712_114426_AlterBuktiPengeluaranPettyCashTable
 */
class m240712_114426_AlterBuktiPengeluaranPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_detail_cash_advance_id',
            $this->integer()->after('reference_number')
        );
        $this->createIndex(
            'idx_bukti_pengeluaran_petty_cash_2',
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_detail_cash_advance_id',
            true
        );
        $this->addForeignKey(
            'fk_bukti_pengeluaran_petty_cash_2',
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_detail_cash_advance_id',
            'job_order_detail_cash_advance',
            'id',
            'SET NULL',
            'CASCADE'
        );


        $this->dropTable('{{%bukti_penerimaan_petty_cash_cash_advance}}');
        $this->dropTable('{{%bukti_pengeluaran_petty_cash_cash_advance}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%bukti_pengeluaran_petty_cash_cash_advance}}', [
            'id' => $this->primaryKey(),
            'bukti_pengeluaran_petty_cash_id' => $this->integer()->notNull(),
            'job_order_detail_cash_advance_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_bukti_pengeluaran_petty_cash_cash_advance_1', '{{%bukti_pengeluaran_petty_cash_cash_advance}}', 'bukti_pengeluaran_petty_cash_id', true);
        $this->createIndex('idx_bukti_pengeluaran_petty_cash_cash_advance_2', '{{%bukti_pengeluaran_petty_cash_cash_advance}}', 'job_order_detail_cash_advance_id', true);
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_cash_advance_1', '{{%bukti_pengeluaran_petty_cash_cash_advance}}', 'bukti_pengeluaran_petty_cash_id', 'bukti_pengeluaran_petty_cash', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bukti_pengeluaran_petty_cash_cash_advance_2', '{{%bukti_pengeluaran_petty_cash_cash_advance}}', 'job_order_detail_cash_advance_id', 'job_order_detail_cash_advance', 'id', 'CASCADE', 'CASCADE',);

        $this->createTable('{{%bukti_penerimaan_petty_cash_cash_advance}}', [
            'id' => $this->primaryKey(),
            'bukti_penerimaan_petty_cash_id' => $this->integer(),
            'bukti_pengeluaran_petty_cash_cash_advance_id' => $this->integer(),
        ]);
        $this->createIndex('idx_bukti_penerimaan_petty_cash_cash_advance_1', '{{%bukti_penerimaan_petty_cash_cash_advance}}', 'bukti_penerimaan_petty_cash_id', true);
        $this->createIndex('idx_bukti_penerimaan_petty_cash_cash_advance_2', '{{%bukti_penerimaan_petty_cash_cash_advance}}', 'bukti_pengeluaran_petty_cash_cash_advance_id', true);
        $this->addForeignKey('fk_bukti_penerimaan_petty_cash_cash_advance_1', '{{%bukti_penerimaan_petty_cash_cash_advance}}', 'bukti_penerimaan_petty_cash_id',
            'bukti_penerimaan_petty_cash',
            'id',
            'CASCADE',
            'CASCADE',
        );
        $this->addForeignKey('fk_bukti_penerimaan_petty_cash_cash_advance_2', '{{%bukti_penerimaan_petty_cash_cash_advance}}', 'bukti_pengeluaran_petty_cash_cash_advance_id',
            'bukti_pengeluaran_petty_cash_cash_advance',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->dropForeignKey(
            'fk_bukti_pengeluaran_petty_cash_2',
            BuktiPengeluaranPettyCash::tableName()
        );
        $this->dropIndex(
            'idx_bukti_pengeluaran_petty_cash_2',
            BuktiPengeluaranPettyCash::tableName()
        );
        $this->dropColumn(
            BuktiPengeluaranPettyCash::tableName(),
            'job_order_detail_cash_advance_id'
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240712_114426_AlterBuktiPengeluaranPettyCashTable cannot be reverted.\n";

        return false;
    }
    */
}
