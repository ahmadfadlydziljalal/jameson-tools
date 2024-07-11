<?php

use yii\db\Migration;

/**
 * Class m240712_033517_AlterJobOrderDetailCashAdvanceTable
 */
class m240712_033517_AlterJobOrderDetailCashAdvanceTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\JobOrderDetailCashAdvance::tableName(), 'order', $this->smallInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\app\models\JobOrderDetailCashAdvance::tableName(), 'order');
    }


}
