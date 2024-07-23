<?php

use app\models\BarangSatuan;
use yii\db\Migration;

/**
 * Class m240723_102930_AlterBarangSatuanTable
 */
class m240723_102930_AlterBarangSatuanTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->alterColumn(BarangSatuan::tableName(), 'vendor_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->alterColumn(BarangSatuan::tableName(), 'vendor_id', $this->integer()->notNull());
    }

}
