<?php

use app\models\BuktiPenerimaanPettyCash;
use yii\db\Migration;
use yii\db\Query;

/**
 * Class m240726_022841_AlterBuktiPenerimaanPettyCashTable
 */
class m240726_022841_AlterBuktiPenerimaanPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $this->addColumn(BuktiPenerimaanPettyCash::tableName(), 'tanggal_transaksi', $this->date());

        $records = (new Query())->from('bukti_penerimaan_petty_cash')->all();
        foreach ($records as $record) {
            Yii::$app->db->createCommand()->update('bukti_penerimaan_petty_cash',
                [
                    'tanggal_transaksi' => date('Y-m-d'),
                ],
                [
                    'id' => $record['id']
                ]
            )->execute();
        }

        $this->alterColumn(BuktiPenerimaanPettyCash::tableName(), 'tanggal_transaksi', $this->date()->notNull());


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(BuktiPenerimaanPettyCash::tableName(), 'tanggal_transaksi');
    }

}
