<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%setoran_kasir}}`.
 */
class m240714_232719_CreateSetoranKasirTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%cashier}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);

        $this->createTable('{{%setoran_kasir}}', [
            'id' => $this->primaryKey(),
            'reference_number' => $this->string(50),
            'tanggal_setoran' => $this->date()->notNull(),
            'cashier_id' => $this->integer()->notNull(),
            'staff_name' => $this->string(50)->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->integer(10)->null()->defaultValue(null),
            'updated_by' => $this->integer(10)->null()->defaultValue(null),
        ]);

        $this->createTable('{{%setoran_kasir_detail}}', [
            'id' => $this->primaryKey(),
            'setoran_kasir_id' => $this->integer(),
            'payment_method_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'total' => $this->decimal(16,2)->notNull(),
        ]);

        $this->createIndex('idx_setoran_kasir_1','{{%setoran_kasir}}' ,'cashier_id' );
        $this->createIndex('idx_setoran_kasir_detail_1','{{%setoran_kasir_detail}}' ,'setoran_kasir_id' );
        $this->createIndex('idx_setoran_kasir_detail_2','{{%setoran_kasir_detail}}' ,'payment_method_id' );

        $this->addForeignKey('fk_setoran_kasir_1','{{%setoran_kasir}}' ,'cashier_id' ,'cashier','id','RESTRICT','CASCADE' );
        $this->addForeignKey('fk_setoran_kasir_detail_1','{{%setoran_kasir_detail}}' ,'setoran_kasir_id', 'setoran_kasir','id','CASCADE','CASCADE' );
        $this->addForeignKey('fk_setoran_kasir_detail_2','{{%setoran_kasir_detail}}' ,'payment_method_id' , 'payment_method','id','RESTRICT','CASCADE' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_setoran_kasir_1','{{%setoran_kasir}}');
        $this->dropForeignKey('fk_setoran_kasir_detail_1','{{%setoran_kasir_detail}}'  );
        $this->dropForeignKey('fk_setoran_kasir_detail_2','{{%setoran_kasir_detail}}' );

        $this->dropIndex('idx_setoran_kasir_1','{{%setoran_kasir}}' );
        $this->dropIndex('idx_setoran_kasir_detail_1','{{%setoran_kasir_detail}}'  );
        $this->dropIndex('idx_setoran_kasir_detail_2','{{%setoran_kasir_detail}}');

        $this->dropTable('{{%setoran_kasir_detail}}');
        $this->dropTable('{{%setoran_kasir}}');
        $this->dropTable('{{%cashier}}');

    }
}
