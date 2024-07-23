<?php

use yii\db\Migration;

/**
 * Class m240722_202723_AlterTransaksiBukuBankLainnyaTable
 */
class m240722_202723_AlterTransaksiBukuBankLainnyaTable extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn(\app\models\TransaksiBukuBankLainnya::tableName(), 'reference_number', $this->string(50)->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn(\app\models\TransaksiBukuBankLainnya::tableName(), 'reference_number');
    }

}
