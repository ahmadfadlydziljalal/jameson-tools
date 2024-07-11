<?php

use app\models\base\BuktiPengeluaranPettyCashCashAdvance;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%bukti_penerimaan_petty_cash}}`.
 */
class m240712_080633_CreateBuktiPenerimaanPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bukti_penerimaan_petty_cash}}', [
            'id' => $this->primaryKey(),
            'reference_number' => $this->string(50),
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
        $this->dropTable('{{%bukti_penerimaan_petty_cash}}');
    }
}
