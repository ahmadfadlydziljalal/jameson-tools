<?php

use yii\db\Migration;

/**
 * Class m240723_113048_InsertBarangSatuanTable
 */
class m240723_113048_InsertBarangSatuanTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $barangsId = \app\models\Barang::find()->select('id')->column();
        foreach ($barangsId as $id) {
            $this->insert(\app\models\BarangSatuan::tableName(), [
               'barang_id' => $id,
               'satuan_id' => 1,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240723_113048_InsertBarangSatuanTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240723_113048_InsertBarangSatuanTable cannot be reverted.\n";

        return false;
    }
    */
}
