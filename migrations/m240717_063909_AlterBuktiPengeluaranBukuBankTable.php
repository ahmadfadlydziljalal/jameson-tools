<?php

use app\models\BuktiPengeluaranBukuBank;
use yii\db\Migration;

/**
 * Class m240717_063909_AlterBuktiPengeluaranBukuBankTable
 */
class m240717_063909_AlterBuktiPengeluaranBukuBankTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn(BuktiPengeluaranBukuBank::tableName(),'is_for_petty_cash', $this->tinyInteger()->defaultValue(0)->after('keterangan'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn(BuktiPengeluaranBukuBank::tableName(),'is_for_petty_cash');
    }


}
