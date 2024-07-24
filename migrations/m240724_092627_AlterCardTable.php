<?php

use app\models\Card;
use yii\db\Migration;

/**
 * Class m240724_092627_AlterCardTable
 */
class m240724_092627_AlterCardTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->alterColumn(Card::tableName(), 'kode', $this->char(50)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->alterColumn(Card::tableName(), 'kode', $this->char(50)->notNull()->unique());
    }

}
