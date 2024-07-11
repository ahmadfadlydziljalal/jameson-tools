<?php

use app\models\Card;
use app\models\JenisBiaya;
use app\models\JobOrder;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%job_order_detail_advance}}`.
 */
class m240710_101325_CreateJobOrderDetailAdvanceTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%job_order_detail_cash_advance}}', [
            'id' => $this->primaryKey(),
            'job_order_id' => $this->integer(),
            'vendor_id' => $this->integer()->notNull(),
            'jenis_biaya_id' => $this->integer()->notNull(),
            'mata_uang_id' => $this->integer()->notNull(),
            'kasbon_request' =>$this->decimal(12,2)->notNull()->defaultValue(0)->comment('Kasbon'),
            'cash_advance' =>$this->decimal(12,2)->notNull()->defaultValue(0)->comment('Panjar'),
        ]);
        $this->createIndex('idx_job_order_detail_cash_advance_1', '{{%job_order_detail_cash_advance}}', 'job_order_id');
        $this->createIndex('idx_job_order_detail_cash_advance_2', '{{%job_order_detail_cash_advance}}', 'vendor_id');
        $this->createIndex('idx_job_order_detail_cash_advance_3', '{{%job_order_detail_cash_advance}}', 'jenis_biaya_id');

        $this->addForeignKey('fk_job_order_detail_cash_advance_1', '{{%job_order_detail_cash_advance}}', 'mata_uang_id',
            \app\models\MataUang::tableName(),
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey('fk_job_order_detail_cash_advance_2', '{{%job_order_detail_cash_advance}}', 'job_order_id',
            JobOrder::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('fk_job_order_detail_cash_advance_3', '{{%job_order_detail_cash_advance}}', 'vendor_id',
            Card::tableName(),
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey('fk_job_order_detail_cash_advance_4', '{{%job_order_detail_cash_advance}}', 'jenis_biaya_id',
            JenisBiaya::tableName(),
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%job_order_detail_cash_advance}}');
    }
}
