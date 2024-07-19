<?php

use app\models\Rekening;
use yii\db\Migration;

/**
 * Class m240719_025157_AlterRekeningTable
 */
class m240719_025157_AlterRekeningTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Rekening::tableName(), 'nama_bank', $this->string()->notNull());
        $this->addColumn(Rekening::tableName(), 'nomor_rekening', $this->string()->notNull());
        $this->addColumn(Rekening::tableName(), 'saldo_awal', $this->decimal(12,2)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Rekening::tableName(), 'nama_bank');
        $this->dropColumn(Rekening::tableName(), 'nomor_rekening');
        $this->dropColumn(Rekening::tableName(), 'saldo_awal');
    }

}
