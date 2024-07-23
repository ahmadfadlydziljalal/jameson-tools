<?php

namespace app\models\form;

use app\models\PettyCash;
use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\db\Query;

class MutasiKasPettyCashReportPerSpecificDate extends Model
{

    private array $transactions = [];
    private ?string $formattedDate = null;


    private ?PettyCash $pettyCash = null;

    private mixed $balanceBeforeDate = null;


    public ?string $date = null;

    public function rules(): array
    {
        return [
            [['date'], 'required'],
        ];
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    private function setTransactions(): void
    {
        $this->transactions = [
            'penerimaan' => $this->findPenerimaanDariBukuBank()
                ->union($this->findPenerimaanPengembalianKasbon(), true)
                ->union($this->findPenerimaanLainnya(), true)
                ->orderBy('voucher')
                ->all()
            ,
            'pengeluaran' => $this->findPengeluaranKasbon()
                ->union($this->findPengeluaranByTagihan(), true)
                ->union($this->findPengeluaranLainnya(), true)
                ->orderBy('voucher')
                ->all(),

        ];
    }

    public function getBalanceBeforeDate()
    {
        return $this->balanceBeforeDate;
    }

    private function setBalanceBeforeDate(): void
    {
        $this->balanceBeforeDate =
            $this->pettyCash->saldo_awal
            + $this->findPenerimaanDariBukuBankBeforeDate()->sum('nominal')
            + $this->findPenerimaanPengembalianKasbonBeforeDate()->sum('cash_advance')
            + $this->findPenerimaanLainnyaBeforeDate()->sum('nominal')
            - $this->findPengeluaranKasbonBeforeDate()->sum('cash_advance')
            - $this->findPengeluaranByTagihanBeforeDate()->sum('nominal')
            - $this->findPengeluaranLainnyaBeforeDate()->sum('nominal');
    }

    public function find()
    {
        $this->formattedDate = Yii::$app->formatter->asDate($this->date, 'php:Y-m-d');
        // Hard code
        $this->pettyCash = PettyCash::find()->one();
        $this->setTransactions();
        $this->setBalanceBeforeDate();
    }

    private function findPenerimaanDariBukuBank(): Query
    {
        return (new Query)
            ->select([
                'voucher' => 'mkpc.nomor_voucher',
                'tanggal_mutasi' => 'mkpc.tanggal_mutasi',
                'nama_card' => 'c.nama',
                'type' => new Expression("'Mutasi Buku Bank'"),
                'job_order' => 'jo.reference_number',
                'bukti_pengeluaran' => 'bpbb.reference_number',
                'buku_bank' => 'bb.nomor_voucher',
                'bukti_penerimaan' => 'bppc.reference_number',
                'nominal' => 'jodpc.nominal',
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin("bukti_penerimaan_petty_cash bppc", 'mkpc.bukti_penerimaan_petty_cash_id = bppc.id')
            ->innerJoin("buku_bank bb", 'bppc.buku_bank_id = bb.id')
            ->innerJoin("bukti_pengeluaran_buku_bank bpbb", 'bb.bukti_pengeluaran_buku_bank_id = bpbb.id')
            ->innerJoin("job_order_detail_petty_cash jodpc", 'bpbb.id = jodpc.bukti_pengeluaran_buku_bank_id')
            ->innerJoin("job_order jo", 'jodpc.job_order_id = jo.id')
            ->innerJoin("card c", 'jodpc.vendor_id = c.id')
            ->where([
                'mkpc.tanggal_mutasi' => $this->formattedDate,
            ]);
    }

    private function findPenerimaanPengembalianKasbon(): Query
    {
        return (new Query())
            ->select([
                'voucher' => 'mkpc.nomor_voucher',
                'tanggal_mutasi' => 'mkpc.tanggal_mutasi',
                'nama_card' => 'c.nama',
                'type' => new Expression("'Pengembalian Kasbon'"),
                'job_order' => 'jo.reference_number',
                'bukti_pengeluaran_petty_cash' => 'b.reference_number',
                'buku_bank' => new Expression("NULL"),
                'bukti_penerimaan_petty_cash' => 'bppc.reference_number',
                'nominal' => 'jodca.cash_advance',

            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin("bukti_penerimaan_petty_cash bppc", 'mkpc.bukti_penerimaan_petty_cash_id = bppc.id')
            ->innerJoin("bukti_pengeluaran_petty_cash b", 'bppc.bukti_pengeluaran_petty_cash_cash_advance_id = b.id')
            ->innerJoin("job_order_detail_cash_advance jodca", 'b.id = jodca.bukti_pengeluaran_petty_cash_id')
            ->innerJoin("job_order jo", 'jodca.job_order_id = jo.id')
            ->innerJoin("card c", "jodca.vendor_id = c.id")
            ->where([
                'mkpc.tanggal_mutasi' => $this->formattedDate,
            ]);

    }

    private function findPenerimaanLainnya(): Query
    {
        return (new Query())
            ->select([
                'voucher' => 'mkpc.nomor_voucher',
                'tanggal_mutasi' => 'mkpc.tanggal_mutasi',
                'nama_card' => 'c.nama',
                'type' => new Expression("'Penerimaan Lainnya'"),
                'job_order' => new Expression("NULL"),
                'bukti_pengeluaran_petty_cash' =>  new Expression("NULL") ,
                'buku_bank' => 'jp.name',
                'bukti_penerimaan_petty_cash' => new Expression("tmkpcl.reference_number"),
                'nominal' => 'tmkpcl.nominal',
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin('transaksi_mutasi_kas_petty_cash_lainnya tmkpcl', 'mkpc.id = tmkpcl.mutasi_kas_petty_cash_id')
            ->innerJoin('jenis_pendapatan jp', 'tmkpcl.jenis_pendapatan_id = jp.id')
            ->innerJoin('card c', 'tmkpcl.card_id = c.id')
            ->where([
                'mkpc.tanggal_mutasi' => $this->formattedDate,
            ]);
    }

    private function findPengeluaranKasbon(): Query
    {
        return (new Query())
            ->select([
                'voucher' => 'mkpc.nomor_voucher',
                'tanggal_mutasi' => 'mkpc.tanggal_mutasi',
                'nama_card' => 'c.nama',
                'type' => new Expression("'Pengeluaran Kasbon'"),
                'job_order' => 'jo.reference_number',
                'bukti_pengeluaran' => 'bppc.reference_number',
                'nominal' => 'jodca.cash_advance',
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin('bukti_pengeluaran_petty_cash bppc', 'mkpc.bukti_pengeluaran_petty_cash_id = bppc.id')
            ->innerJoin('job_order_detail_cash_advance jodca', 'bppc.id =  jodca.bukti_pengeluaran_petty_cash_id')
            ->innerJoin('job_order jo', 'jodca.job_order_id = jo.id')
            ->innerJoin('card c', ' jodca.vendor_id = c.id')
            ->where([
                'mkpc.tanggal_mutasi' => $this->formattedDate,
            ]);
    }

    private function findPengeluaranByTagihan(): Query
    {
        return (new Query())
            ->select([
                'voucher' => 'mkpc.nomor_voucher',
                'tanggal_mutasi' => 'mkpc.tanggal_mutasi',
                'nama_card' => 'c.nama',
                'type' => new Expression("'Pengeluaran Pembayaran Tagihan'"),
                'job_order' => 'jo.reference_number',
                'bukti_pengeluaran_petty_cash' => 'bppc.reference_number',
                'nominal' => new Expression("SUM(jobd.quantity * jobd.price)"),

            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin('bukti_pengeluaran_petty_cash bppc', 'mkpc.bukti_pengeluaran_petty_cash_id = bppc.id')
            ->innerJoin('job_order_bill job', 'bppc.id = job.bukti_pengeluaran_petty_cash_id')
            ->innerJoin('job_order_bill_detail jobd', 'job.id = jobd.job_order_bill_id')
            ->innerJoin('card c', 'job.vendor_id = c.id')
            ->innerJoin('job_order jo', 'job.job_order_id = jo.id')
            ->groupBy('mkpc.id')
            ->where([
                'mkpc.tanggal_mutasi' => $this->formattedDate,
            ]);
    }

    private function findPengeluaranLainnya(): Query
    {
        return (new Query())
            ->select([
                'voucher' => 'mkpc.nomor_voucher',
                'tanggal_mutasi' => 'mkpc.tanggal_mutasi',
                'nama_card' => 'c.nama',
                'type' => new Expression("'Pengeluaran Lainnya'"),
                'job_order' => new Expression("jb.name"),
                'bukti_pengeluaran_petty_cash' => 'tmkpcl.reference_number',
                'nominal' => new Expression("tmkpcl.nominal"),
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin('transaksi_mutasi_kas_petty_cash_lainnya tmkpcl', 'mkpc.id = tmkpcl.mutasi_kas_petty_cash_id')
            ->innerJoin('jenis_biaya jb', 'tmkpcl.jenis_biaya_id = jb.id')
            ->innerJoin('card c', 'tmkpcl.card_id = c.id')
            ->where([
                'mkpc.tanggal_mutasi' => $this->formattedDate,
            ]);

    }


    private function findPenerimaanDariBukuBankBeforeDate(): Query
    {
        return (new Query)
            ->select([
                'nominal' => 'jodpc.nominal',
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin("bukti_penerimaan_petty_cash bppc", 'mkpc.bukti_penerimaan_petty_cash_id = bppc.id')
            ->innerJoin("buku_bank bb", 'bppc.buku_bank_id = bb.id')
            ->innerJoin("bukti_pengeluaran_buku_bank bpbb", 'bb.bukti_pengeluaran_buku_bank_id = bpbb.id')
            ->innerJoin("job_order_detail_petty_cash jodpc", 'bpbb.id = jodpc.bukti_pengeluaran_buku_bank_id')
            ->innerJoin("job_order jo", 'jodpc.job_order_id = jo.id')
            ->innerJoin("card c", 'jodpc.vendor_id = c.id')
            ->where([
                '<', 'mkpc.tanggal_mutasi', $this->formattedDate,
            ]);
    }

    private function findPenerimaanPengembalianKasbonBeforeDate(): Query
    {
        return (new Query())
            ->select([
                'cash_advance' => 'jodca.cash_advance',
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin("bukti_penerimaan_petty_cash bppc", 'mkpc.bukti_penerimaan_petty_cash_id = bppc.id')
            ->innerJoin("bukti_pengeluaran_petty_cash b", 'bppc.bukti_pengeluaran_petty_cash_cash_advance_id = b.id')
            ->innerJoin("job_order_detail_cash_advance jodca", 'b.id = jodca.bukti_pengeluaran_petty_cash_id')
            ->innerJoin("job_order jo", 'jodca.job_order_id = jo.id')
            ->innerJoin("card c", "jodca.vendor_id = c.id")
            ->where([
                '<', 'mkpc.tanggal_mutasi', $this->formattedDate,
            ]);

    }

    private function findPenerimaanLainnyaBeforeDate(): Query
    {
        return (new Query())
            ->select([
                'nominal' => 'tmkpcl.nominal'
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin('transaksi_mutasi_kas_petty_cash_lainnya tmkpcl', 'mkpc.id = tmkpcl.mutasi_kas_petty_cash_id')
            ->innerJoin('jenis_pendapatan jp', 'tmkpcl.jenis_pendapatan_id = jp.id')
            ->innerJoin('card c', 'tmkpcl.card_id = c.id')
            ->where([
                '<', 'mkpc.tanggal_mutasi', $this->formattedDate,
            ]);
    }


    private function findPengeluaranKasbonBeforeDate(): Query
    {
        return (new Query())
            ->select([
                'cash_advance' => 'jodca.cash_advance',
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin('bukti_pengeluaran_petty_cash bppc', 'mkpc.bukti_pengeluaran_petty_cash_id = bppc.id')
            ->innerJoin('job_order_detail_cash_advance jodca', 'bppc.id =  jodca.bukti_pengeluaran_petty_cash_id')
            ->innerJoin('job_order jo', 'jodca.job_order_id = jo.id')
            ->innerJoin('card c', ' jodca.vendor_id = c.id')
            ->where([
                '<', 'mkpc.tanggal_mutasi', $this->formattedDate,
            ]);
    }

    private function findPengeluaranByTagihanBeforeDate(): Query
    {
        return (new Query())
            ->select([
                'nominal' => new Expression("SUM(jobd.quantity * jobd.price)"),
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin('bukti_pengeluaran_petty_cash bppc', 'mkpc.bukti_pengeluaran_petty_cash_id = bppc.id')
            ->innerJoin('job_order_bill job', 'bppc.id = job.bukti_pengeluaran_petty_cash_id')
            ->innerJoin('job_order_bill_detail jobd', 'job.id = jobd.job_order_bill_id')
            ->innerJoin('card c', 'job.vendor_id = c.id')
            ->innerJoin('job_order jo', 'job.job_order_id = jo.id')
            ->groupBy('mkpc.id')
            ->where([
                '<', 'mkpc.tanggal_mutasi', $this->formattedDate,
            ]);
    }

    private function findPengeluaranLainnyaBeforeDate(): Query
    {
        return (new Query())
            ->select([
                'nominal' => new Expression("tmkpcl.nominal")
            ])
            ->from(['mkpc' => 'mutasi_kas_petty_cash'])
            ->innerJoin('transaksi_mutasi_kas_petty_cash_lainnya tmkpcl', 'mkpc.id = tmkpcl.mutasi_kas_petty_cash_id')
            ->innerJoin('jenis_biaya jb', 'tmkpcl.jenis_biaya_id = jb.id')
            ->innerJoin('card c', 'tmkpcl.card_id = c.id')
            ->where([
                '<', 'mkpc.tanggal_mutasi', $this->formattedDate,
            ]);

    }

    public function getTotalPenerimaan(): float|int
    {
        return  array_sum((array_column($this->transactions['penerimaan'], 'nominal')));
    }

    public function getTotalPengeluaran(): float|int
    {
        return  array_sum((array_column($this->transactions['pengeluaran'], 'nominal')));
    }

    public function getSaldoAkhir()
    {
        return $this->getBalanceBeforeDate() + $this->getTotalPenerimaan() - $this->getTotalPengeluaran();
    }

}