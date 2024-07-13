<?php

use yii\db\Migration;

/**
 * Class m240713_015332_AlterKodeVoucherTable
 */
class m240713_015332_AlterKodeVoucherTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('kode_voucher', 'code', $this->smallInteger()->after('name')->unique());
        $this->addColumn('kode_voucher', 'singkatan', $this->char(8)->after('code'));
        $this->addColumn('kode_voucher', 'type', $this->smallInteger()->after('singkatan'));
        $this->dropColumn('mutasi_kas_petty_cash', 'nomor');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('mutasi_kas_petty_cash', 'nomor', $this->integer()->after('bukti_pengeluaran_petty_cash_id'));
        $this->alterColumn('kode_voucher', 'code', $this->smallInteger()->after('name')->unique());
        $this->dropColumn('kode_voucher', 'singkatan');
        $this->dropColumn('kode_voucher', 'type');
    }

}
