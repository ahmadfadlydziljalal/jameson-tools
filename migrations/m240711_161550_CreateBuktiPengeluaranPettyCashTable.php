<?php

use app\models\JobOrderDetailCashAdvance;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%bukti_pengeluaran_petty_cash}}`.
 */
class m240711_161550_CreateBuktiPengeluaranPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bukti_pengeluaran_petty_cash}}', [
            'id' => $this->primaryKey(),
            'reference_number' => $this->string()->null(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%bukti_pengeluaran_petty_cash_cash_advance}}');
        $this->dropTable('{{%bukti_pengeluaran_petty_cash}}');
    }
}
