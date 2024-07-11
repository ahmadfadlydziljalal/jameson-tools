<?php

use app\models\Card;
use app\models\JobOrder;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%job_order_detail_biaya}}`.
 */
class m240711_103805_CreateJobOrderDetailBiayaTable extends Migration
{
    private string $table = '{{%job_order_bill}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'job_order_id' => $this->integer(),
            'vendor_id' => $this->integer()->notNull(),
            'reference_number' => $this->string()->notNull(),
        ]);

        $this->createIndex('idx_job_order_detail_biaya_1', $this->table, 'job_order_id');
        $this->createIndex('idx_job_order_detail_biaya_2', $this->table, 'vendor_id');

        $this->addForeignKey('fk_job_order_detail_biaya_1', $this->table, 'job_order_id',
            JobOrder::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('fk_job_order_detail_biaya_2', $this->table, 'vendor_id',
            Card::tableName(),
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
        $this->dropTable($this->table);
    }
}
