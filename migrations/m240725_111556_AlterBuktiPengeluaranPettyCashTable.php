<?php

use app\models\BuktiPengeluaranPettyCash;
use yii\db\Migration;

/**
 * Class m240725_111556_AlterBuktiPengeluaranPettyCashTable
 */
class m240725_111556_AlterBuktiPengeluaranPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn(BuktiPengeluaranPettyCash::tableName(), 'tanggal_transaksi', $this->date()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(BuktiPengeluaranPettyCash::tableName(), 'tanggal_transaksi');
    }

}
