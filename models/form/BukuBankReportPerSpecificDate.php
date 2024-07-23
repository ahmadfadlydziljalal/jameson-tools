<?php

namespace app\models\form;

use app\models\Rekening;
use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\db\Query;


/**
 *
 * @property-read Rekening $bank
 * @property-read mixed balanceBeforeDate
 * @property-read array $transactions
 * @property-read null|mixed $endingBalance
 * @property mixed $sumCredit
 * @property mixed $sumDebit
 */
class BukuBankReportPerSpecificDate extends Model
{

    public ?string $date = null;
    public ?string $rekening = null;

    private ?string $formattedDate = null;

    private ?Rekening $bank = null;
    private mixed $balanceBeforeDate = null;
    private array $transactions = [];

    /**
     * @return Rekening|null
     */
    public function getBank(): ?Rekening
    {
        return $this->bank;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getBalanceBeforeDate()
    {
        return $this->balanceBeforeDate;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['date', 'rekening'], 'required'],
        ];
    }

    public function find(): void
    {
        /**
         * 1. Cari dulu berapa modal di akun bank tersebut
         *
         * 2. Cari Penerimaannya
         * 2.1 Penerimaan dari bukti penerimaan buku bank
         * 2.2 Penerimaan buku bank lainnya
         *
         * 3. Cari Pengeluaran
         * 3.1 Pengeluarann dari bukti pengeluaran buku bank
         * 3.2 Pengeluaran buku bank lainnya
         *
         */
        $this->formattedDate = Yii::$app->formatter->asDate($this->date, 'php:Y-m-d');
        $this->setBank();
        $this->setBalanceBeforeDate();
        $this->setTransactions();
    }

    private function setBank(): void
    {
        $this->bank = Rekening::findOne($this->rekening);
    }

    private function setBalanceBeforeDate(): void
    {
        $data = $this->findPenerimaanInvoiceBeforeDate()
            ->union($this->findPenerimaanSetoranKasirBeforeDate(), true)
            ->union($this->findPenerimaanLainnyaBeforeDate(), true)
            ->union($this->findPengeluaranPembayaranCashAdvanceBeforeDate(), true)
            ->union($this->findPengeluaranPembayaranBillBeforeDate(), true)
            ->union($this->findPengeluaranMutasiKasBeforeDate(), true)
            ->union($this->findPengeluaranLainnyaBeforeDate(), true);

        $transaction = (new Query())
            ->select([
                'totalDebit' => new Expression("SUM(debit)"),
                'totalCredit' => new Expression("SUM(credit)"),
            ])
            ->from(['data' => $data])
            ->one();

        $this->balanceBeforeDate = $this->bank->saldo_awal + $transaction['totalDebit'] - $transaction['totalCredit'];
    }

    private function setTransactions(): void
    {

        $this->transactions = $this->findPenerimaanInvoice()
            ->union($this->findPenerimaanSetoranKasir(), true)
            ->union($this->findPenerimaanLainnya(), true)
            ->union($this->findPengeluaranPembayaranCashAdvance(), true)
            ->union($this->findPengeluaranPembayaranBill(), true)
            ->union($this->findPengeluaranMutasiKas(), true)
            ->union($this->findPengeluaranLainnya(), true)
            ->orderBy('nomor_voucher')
            ->all();
    }

    private function findPenerimaanInvoiceBeforeDate(): Query
    {
        return (new Query())
            ->select(['type' => new Expression("'Penerimaan Invoice'")])
            ->addSelect([
                'debit' => new Expression("SUM(d.quantity * d.harga)"),
                'credit' => new Expression("0"),
            ])
            ->from(['bb' => 'buku_bank'])
            ->innerJoin("bukti_penerimaan_buku_bank bpbb", "bb.bukti_penerimaan_buku_bank_id = bpbb.id")
            ->innerJoin("invoice i", " bpbb.id = i.bukti_penerimaan_buku_bank_id")
            ->innerJoin("invoice_detail d", "i.id = d.invoice_id")
            ->innerJoin("card c", "bpbb.customer_id = c.id")
            ->innerJoin("jenis_transfer jt", "bpbb.jenis_transfer_id = jt.id")
            ->where([
                '<', 'bb.tanggal_transaksi', $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ])
            ->groupBy('bb.id');
    }

    private function findPenerimaanSetoranKasirBeforeDate(): Query
    {
        return (new Query())
            ->select(['type' => new Expression("'Penerimaan Setoran Kasir'")])
            ->addSelect([
                'debit' => new Expression("SUM(skd.quantity * skd.total)"),
                'credit' => new Expression("0"),
            ])
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('bukti_penerimaan_buku_bank bpbb', 'bb.bukti_penerimaan_buku_bank_id = bpbb.id')
            ->innerJoin('setoran_kasir sk', 'bpbb.id = sk.bukti_penerimaan_buku_bank_id')
            ->innerJoin('card c', 'bpbb.customer_id = c.id')
            ->innerJoin('jenis_transfer jt', 'bpbb.jenis_transfer_id = jt.id')
            ->innerJoin('setoran_kasir_detail skd', 'sk.id = skd.setoran_kasir_id')
            ->where([
                '<', 'bb.tanggal_transaksi', $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ])
            ->groupBy('bb.id');
    }

    private function findPenerimaanLainnyaBeforeDate(): Query
    {
        return (new Query())
            ->select(['type' => new Expression("'Transaksi Penerimaan Lainnya'")])
            ->addSelect([
                'debit' => 'tbbl.nominal',
                'credit' => new Expression("0"),
            ])
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('transaksi_buku_bank_lainnya tbbl', 'bb.id = tbbl.buku_bank_id')
            ->innerJoin('card c', 'tbbl.card_id = c.id')
            ->innerJoin('jenis_pendapatan jp', 'tbbl.jenis_pendapatan_id = jp.id')
            ->where(['IS NOT', 'tbbl.jenis_pendapatan_id', NULL])
            ->andWhere(['<', 'bb.tanggal_transaksi', $this->formattedDate,])
            ->andWhere(['tbbl.rekening_id' => $this->rekening,]);
    }

    private function findPengeluaranPembayaranCashAdvanceBeforeDate(): Query
    {
        return (new Query())
            ->addSelect(['type' => new Expression("'Kasbon'")])
            ->addSelect(["debit" => new Expression("0"),])
            ->addSelect("jodca.cash_advance                           AS credit ")
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('bukti_pengeluaran_buku_bank bpbb', 'bb.bukti_pengeluaran_buku_bank_id = bpbb.id')
            ->innerJoin('card c', 'bpbb.vendor_id = c.id')
            ->innerJoin('job_order_detail_cash_advance jodca', 'bpbb.id = jodca.bukti_pengeluaran_buku_bank_id')
            ->innerJoin('job_order jo', 'jodca.job_order_id = jo.id')
            ->where([
                '<', 'bb.tanggal_transaksi', $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ]);
    }

    private function findPengeluaranPembayaranBillBeforeDate(): Query
    {
        return (new Query())
            ->select(['type' => new Expression("'Pembayaran Tagihan'")])
            ->addSelect(["debit" => new Expression("0")])
            ->addSelect(['credit' => new Expression("ROUND(SUM(jobd.quantity * jobd.price), 2)")])
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('bukti_pengeluaran_buku_bank bpbb', 'bb.bukti_pengeluaran_buku_bank_id = bpbb.id')
            ->innerJoin('job_order_bill job', 'bpbb.id = job.bukti_pengeluaran_buku_bank_id')
            ->innerJoin('job_order_bill_detail jobd', 'job.id = jobd.job_order_bill_id')
            ->innerJoin('job_order jo', 'job.job_order_id = jo.id')
            ->innerJoin('card c', 'bpbb.vendor_id = c.id')
            ->where(['<', 'bb.tanggal_transaksi', $this->formattedDate,])
            ->andWhere(['bpbb.rekening_saya_id' => $this->rekening,])
            ->groupBy('bb.id, jo.id');
    }

    private function findPengeluaranMutasiKasBeforeDate(): Query
    {
        return (new Query())
            ->select(['type' => new Expression("'Mutasi Kas'")])
            ->addSelect(["debit" => new Expression("0")])
            ->addSelect(" jodpc.nominal AS credit ")
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('bukti_pengeluaran_buku_bank bpbb', 'bpbb.id = bb.bukti_pengeluaran_buku_bank_id')
            ->innerJoin('job_order_detail_petty_cash jodpc', 'bpbb.id = jodpc.bukti_pengeluaran_buku_bank_id')
            ->innerJoin('job_order jo', 'jodpc.job_order_id = jo.id')
            ->innerJoin('card c', 'bpbb.vendor_id = c.id')
            ->innerJoin('bukti_penerimaan_petty_cash bppc', 'bb.id = bppc.buku_bank_id')
            ->innerJoin('mutasi_kas_petty_cash mkpc', 'bppc.id = mkpc.bukti_penerimaan_petty_cash_id')
            ->where([
                '<', 'bb.tanggal_transaksi', $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ]);
    }

    private function findPengeluaranLainnyaBeforeDate(): Query
    {
        return (new Query())
            ->select(['type' => new Expression("'Transaksi Pengeluaran Lainnya'")])
            ->addSelect(["debit" => new Expression("0")])
            ->addSelect("tbbl.nominal AS credit")
            ->from(['bb' => 'buku_bank'])
            ->innerJoin("transaksi_buku_bank_lainnya tbbl", "bb.id = tbbl.buku_bank_id")
            ->innerJoin("card c", "tbbl.card_id = c.id")
            ->innerJoin("jenis_biaya jb", "tbbl.jenis_biaya_id = jb.id")
            ->where(['IS NOT', 'tbbl.jenis_biaya_id', NULL])
            ->andWhere(['<', 'bb.tanggal_transaksi', $this->formattedDate,])
            ->andWhere(['tbbl.rekening_id' => $this->rekening,]);
    }

    private function findPenerimaanInvoice(): Query
    {
        return (new Query())
            ->select("
               bb.id                                                        AS id,
               bb.nomor_voucher                                             AS voucher,
               bb.tanggal_transaksi                                         AS tanggal_transaksi,
               c.nama                                                       AS nama
            ")
            ->addSelect(['type' => new Expression("'Penerimaan Invoice'")])
            ->addSelect(['document' => new Expression("GROUP_CONCAT(DISTINCT i.reference_number)")])
            ->addSelect("
               jt.name                                   AS source_request,
               bpbb.reference_number                     as referensi,                
            ")
            ->addSelect([
                'debit' => new Expression("SUM(d.quantity * d.harga)"),
                'credit' => new Expression("0"),
            ])
            ->from(['bb' => 'buku_bank'])
            ->innerJoin("bukti_penerimaan_buku_bank bpbb", "bb.bukti_penerimaan_buku_bank_id = bpbb.id")
            ->innerJoin("invoice i", " bpbb.id = i.bukti_penerimaan_buku_bank_id")
            ->innerJoin("invoice_detail d", "i.id = d.invoice_id")
            ->innerJoin("card c", "bpbb.customer_id = c.id")
            ->innerJoin("jenis_transfer jt", "bpbb.jenis_transfer_id = jt.id")
            ->where([
                'bb.tanggal_transaksi' => $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ])
            ->groupBy('bb.id');
    }

    private function findPenerimaanSetoranKasir(): Query
    {
        return (new Query())
            ->select("
               bb.id                                                        AS id,
               bb.nomor_voucher                                             AS voucher,
               bb.tanggal_transaksi                                         AS tanggal_transaksi,
               c.nama                                                       AS nama            
            ")
            ->addSelect(['type' => new Expression("'Penerimaan Setoran Kasir'")])
            ->addSelect(['setoran' => new Expression("GROUP_CONCAT(DISTINCT sk.reference_number)")])
            ->addSelect("
               jt.name                                    AS source_request,
               bpbb.reference_number                      AS referensi,
            ")
            ->addSelect([
                'debit' => new Expression("SUM(skd.quantity * skd.total)"),
                'credit' => new Expression("0"),
            ])
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('bukti_penerimaan_buku_bank bpbb', 'bb.bukti_penerimaan_buku_bank_id = bpbb.id')
            ->innerJoin('setoran_kasir sk', 'bpbb.id = sk.bukti_penerimaan_buku_bank_id')
            ->innerJoin('card c', 'bpbb.customer_id = c.id')
            ->innerJoin('jenis_transfer jt', 'bpbb.jenis_transfer_id = jt.id')
            ->innerJoin('setoran_kasir_detail skd', 'sk.id = skd.setoran_kasir_id')
            ->where([
                'bb.tanggal_transaksi' => $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ])
            ->groupBy('bb.id');
    }

    private function findPenerimaanLainnya(): Query
    {
        return (new Query())
            ->select("
                bb.id                          as id,
                bb.nomor_voucher,
                bb.tanggal_transaksi,
                c.nama            
            ")
            ->addSelect(['type' => new Expression("'Transaksi Penerimaan Lainnya'")])
            ->addSelect(['jenis_pendapatan' => new Expression("jp.name")])
            ->addSelect("
                tbbl.keterangan                as source_request,
                tbbl.reference_number          as referensi,  
            ")
            ->addSelect([
                'debit' => 'tbbl.nominal',
                'credit' => new Expression("0"),
            ])
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('transaksi_buku_bank_lainnya tbbl', 'bb.id = tbbl.buku_bank_id')
            ->innerJoin('card c', 'tbbl.card_id = c.id')
            ->innerJoin('jenis_pendapatan jp', 'tbbl.jenis_pendapatan_id = jp.id')
            ->where([
                'IS NOT', 'tbbl.jenis_pendapatan_id', NULL
            ])
            ->andWhere([
                'bb.tanggal_transaksi' => $this->formattedDate,
            ])
            ->andWhere([
                'tbbl.rekening_id' => $this->rekening,
            ]);
    }

    private function findPengeluaranPembayaranCashAdvance(): Query
    {
        return (new Query())
            ->select("
               bb.id                                                  AS id,
               bb.nomor_voucher                                       AS voucher,
               bb.tanggal_transaksi                                   AS tanggal_transaksi,
               c.nama                                                 AS nama,
               ")
            ->addSelect(['type' => new Expression("'Kasbon'")])
            ->addSelect("
               jo.reference_number                                    AS job_order,
               CONCAT('Kasbon ke ', jodca.`order`)                    AS source_request,
               bpbb.reference_number                                  AS referensi,"
            )
            ->addSelect(["debit" => new Expression("0"),])
            ->addSelect("jodca.cash_advance                           AS credit ")
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('bukti_pengeluaran_buku_bank bpbb', 'bb.bukti_pengeluaran_buku_bank_id = bpbb.id')
            ->innerJoin('card c', 'bpbb.vendor_id = c.id')
            ->innerJoin('job_order_detail_cash_advance jodca', 'bpbb.id = jodca.bukti_pengeluaran_buku_bank_id')
            ->innerJoin('job_order jo', 'jodca.job_order_id = jo.id')
            ->where([
                'bb.tanggal_transaksi' => $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ]);
    }

    private function findPengeluaranPembayaranBill(): Query
    {
        return (new Query())
            ->select("
               bb.id                                                        AS id,
               bb.nomor_voucher                                             AS voucher,
               bb.tanggal_transaksi                                         AS tanggal_transaksi,
               c.nama                                                       AS nama,
            ")
            ->addSelect(['type' => new Expression("'Pembayaran Tagihan'")])
            ->addSelect(" jo.reference_number                               AS job_order, ")
            ->addSelect([
                "source_request" => new Expression("GROUP_CONCAT(DISTINCT job.reference_number)"),
            ])
            ->addSelect("bpbb.reference_number                              AS referensi")
            ->addSelect(["debit" => new Expression("0")])
            ->addSelect(['credit' => new Expression("ROUND(SUM(jobd.quantity * jobd.price), 2)")])
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('bukti_pengeluaran_buku_bank bpbb', 'bb.bukti_pengeluaran_buku_bank_id = bpbb.id')
            ->innerJoin('job_order_bill job', 'bpbb.id = job.bukti_pengeluaran_buku_bank_id')
            ->innerJoin('job_order_bill_detail jobd', 'job.id = jobd.job_order_bill_id')
            ->innerJoin('job_order jo', 'job.job_order_id = jo.id')
            ->innerJoin('card c', 'bpbb.vendor_id = c.id')
            ->where([
                'bb.tanggal_transaksi' => $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ])
            ->groupBy('bb.id, jo.id');
    }

    private function findPengeluaranMutasiKas(): Query
    {
        return (new Query())
            ->select("
               bb.id                                                        AS id,
               bb.nomor_voucher                                             AS voucher,
               bb.tanggal_transaksi                                         AS tanggal_transaksi,
               c.nama                                                       AS nama,
            ")
            ->addSelect(['type' => new Expression("'Mutasi Kas'")])
            ->addSelect("
                jo.reference_number                                 AS job_order,
                mkpc.nomor_voucher                                  AS source_request   
             ")
            ->addSelect(['referensi' => new Expression("CONCAT(bpbb.reference_number, ' - ', bppc.reference_number)")])
            ->addSelect(["debit" => new Expression("0")])
            ->addSelect("
                jodpc.nominal                                               AS credit
            ")
            ->from(['bb' => 'buku_bank'])
            ->innerJoin('bukti_pengeluaran_buku_bank bpbb', 'bpbb.id = bb.bukti_pengeluaran_buku_bank_id')
            ->innerJoin('job_order_detail_petty_cash jodpc', 'bpbb.id = jodpc.bukti_pengeluaran_buku_bank_id')
            ->innerJoin('job_order jo', 'jodpc.job_order_id = jo.id')
            ->innerJoin('card c', 'bpbb.vendor_id = c.id')
            ->innerJoin('bukti_penerimaan_petty_cash bppc', 'bb.id = bppc.buku_bank_id')
            ->innerJoin('mutasi_kas_petty_cash mkpc', 'bppc.id = mkpc.bukti_penerimaan_petty_cash_id')
            ->where([
                'bb.tanggal_transaksi' => $this->formattedDate,
            ])
            ->andWhere([
                'bpbb.rekening_saya_id' => $this->rekening,
            ]);
    }

    private function findPengeluaranLainnya(): Query
    {
        return (new Query())
            ->select("
               bb.id                                                                    AS id,
               bb.nomor_voucher                                                         AS voucher,
               bb.tanggal_transaksi                                                     AS tanggal_transaksi,
               c.nama                                                                   AS nama,
            ")
            ->addSelect(['type' => new Expression("'Transaksi Pengeluaran Lainnya'")])
            ->addSelect(["jenis_biaya" => new Expression("jb.name")])
            ->addSelect("
               tbbl.keterangan                                                          AS source_request,
               tbbl.reference_number                                                    AS referensi,
            ")
            ->addSelect(["debit" => new Expression("0")])
            ->addSelect("tbbl.nominal                                                   AS credit")
            ->from(['bb' => 'buku_bank'])
            ->innerJoin("transaksi_buku_bank_lainnya tbbl", "bb.id = tbbl.buku_bank_id")
            ->innerJoin("card c", "tbbl.card_id = c.id")
            ->innerJoin("jenis_biaya jb", "tbbl.jenis_biaya_id = jb.id")
            ->where([
                'IS NOT', 'tbbl.jenis_biaya_id', NULL
            ])
            ->andWhere([
                'bb.tanggal_transaksi' => $this->formattedDate,
            ])
            ->andWhere([
                'tbbl.rekening_id' => $this->rekening,
            ]);
    }

    public function getSumDebit(): float|int
    {
        return array_sum(array_column($this->transactions, 'debit'));
    }

    public function getSumCredit(): float|int
    {
        return array_sum(array_column($this->transactions, 'credit'));
    }

    public function getEndingBalance()
    {
        return $this->balanceBeforeDate +
            $this->sumDebit -
            $this->sumCredit;
    }



}