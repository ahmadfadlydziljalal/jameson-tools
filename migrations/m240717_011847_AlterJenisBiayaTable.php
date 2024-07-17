<?php

use app\models\JenisBiaya;
use yii\db\Migration;

/**
 * Class m240717_011847_AlterJenisBiayaTable
 */
class m240717_011847_AlterJenisBiayaTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn(JenisBiaya::tableName(), 'category', $this->tinyInteger()->after('description'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn(JenisBiaya::tableName(), 'category');
    }

}
