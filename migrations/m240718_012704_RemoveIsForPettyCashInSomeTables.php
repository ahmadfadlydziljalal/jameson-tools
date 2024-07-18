<?php

use app\models\BuktiPengeluaranBukuBank;
use app\models\JobOrder;
use yii\db\Migration;

/**
 * Class m240718_012704_RemoveIsForPettyCashInSomeTables
 */
class m240718_012704_RemoveIsForPettyCashInSomeTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->dropColumn(JobOrder::tableName(),'is_for_petty_cash');
        $this->dropColumn(BuktiPengeluaranBukuBank::tableName(),'is_for_petty_cash');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn(BuktiPengeluaranBukuBank::tableName(),'is_for_petty_cash');
        $this->addColumn(JobOrder::tableName(),'is_for_petty_cash', $this->tinyInteger()->defaultValue(0)->after('main_customer_id'));
    }

}
