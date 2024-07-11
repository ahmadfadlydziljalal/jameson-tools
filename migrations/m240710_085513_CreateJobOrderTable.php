<?php

use app\models\Card;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%job_order}}`.
 */
class m240710_085513_CreateJobOrderTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%job_order}}', [
            'id' => $this->primaryKey(),
            'reference_number' => $this->char(24),
            'main_vendor_id' => $this->integer()->notNull()->comment('Kepada'),
            'main_customer_id' => $this->integer()->notNull()->comment('Ditagihkan'),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);

        $this->createIndex('idx_job_order_main_vendor_id', '{{%job_order}}', 'main_vendor_id');
        $this->createIndex('idx_job_order_main_customer_id', '{{%job_order}}', 'main_customer_id');
        $this->addForeignKey('fk_job_order_main_vendor_id', '{{%job_order}}', 'main_vendor_id',
            Card::tableName(),
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey('fk_job_order_main_customer_id', '{{%job_order}}', 'main_customer_id',
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
        $this->dropTable('{{%job_order}}');
    }
}
