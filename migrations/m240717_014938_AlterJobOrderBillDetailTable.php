<?php

use app\models\base\JenisBiaya;
use app\models\JobOrderBillDetail;
use yii\db\Migration;

/**
 * Class m240717_014938_AlterJobOrderBillDetailTable
 */
class m240717_014938_AlterJobOrderBillDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(JobOrderBillDetail::tableName(),'jenis_biaya_id', $this->integer()->notNull()->after('job_order_bill_id'));
        $this->createIndex('idx_job_order_bill_detail_3', JobOrderBillDetail::tableName(),'jenis_biaya_id');
        $this->addForeignKey('fk_job_order_bill_detail_3', JobOrderBillDetail::tableName(),'jenis_biaya_id',
            JenisBiaya::tableName(),
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
        $this->dropForeignKey('fk_job_order_bill_detail_3', JobOrderBillDetail::tableName());
        $this->dropIndex('idx_job_order_bill_detail_3', JobOrderBillDetail::tableName());
        $this->dropColumn(JobOrderBillDetail::tableName(),'jenis_biaya_id');
    }

}
