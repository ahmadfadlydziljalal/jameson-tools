<?php

use app\models\TransaksiMutasiKasPettyCashLainnya;
use yii\db\Migration;

/**
 * Class m240723_042047_AlterMutasiKasPettyCashLainnya
 */
class m240723_042047_AlterMutasiKasPettyCashLainnya extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn(TransaksiMutasiKasPettyCashLainnya::tableName(), 'reference_number', $this->string(50)->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn(TransaksiMutasiKasPettyCashLainnya::tableName(), 'reference_number');
    }

}
