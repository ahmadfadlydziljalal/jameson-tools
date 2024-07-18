<?php

use app\models\Rekening;
use app\models\TransaksiBukuBankLainnya;
use yii\db\Migration;

/**
 * Class m240717_122110_AlterTransaksiBukuBankLainnyaTable
 */
class m240717_122110_AlterTransaksiBukuBankLainnyaTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn(TransaksiBukuBankLainnya::tableName(),'rekening_id', $this->integer()->notNull()->after('buku_bank_id'));
        $this->createIndex('idx_transaksi_buku_bank_lainnya_5', TransaksiBukuBankLainnya::tableName(),'rekening_id');
        $this->addForeignKey('fk_transaksi_buku_bank_lainnya_5', TransaksiBukuBankLainnya::tableName(),'rekening_id',
            Rekening::tableName(),
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk_transaksi_buku_bank_lainnya_5', TransaksiBukuBankLainnya::tableName());
        $this->dropIndex('idx_transaksi_buku_bank_lainnya_5', TransaksiBukuBankLainnya::tableName());
        $this->dropColumn(TransaksiBukuBankLainnya::tableName(),'rekening_id');
    }

}
