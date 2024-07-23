<?php

use app\models\Barang;
use yii\db\Migration;

/**
 * Class m240723_101514_AlterBarangTable
 */
class m240723_101514_AlterBarangTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(Barang::tableName(), 'tipe_pembelian_id', $this->integer()->null());
        $this->alterColumn(Barang::tableName(), 'originalitas_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(Barang::tableName(), 'tipe_pembelian_id', $this->integer()->notNull());
        $this->alterColumn(Barang::tableName(), 'originalitas_id', $this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240723_101514_AlterBarangTable cannot be reverted.\n";

        return false;
    }
    */
}
