<?php

use app\models\JobOrder;
use yii\db\Migration;

/**
 * Class m240717_024833_AlterJobOrderTable
 */
class m240717_024833_AlterJobOrderTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(JobOrder::tableName(),'is_for_petty_cash', $this->tinyInteger()->defaultValue(0)->after('main_customer_id'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(JobOrder::tableName(),'is_for_petty_cash');
    }


}
