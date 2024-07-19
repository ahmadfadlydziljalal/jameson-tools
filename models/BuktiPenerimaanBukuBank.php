<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\BuktiPenerimaanBukuBank as BaseBuktiPenerimaanBukuBank;
use Yii;
use yii\db\Exception;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "bukti_penerimaan_buku_bank".
 */
class BuktiPenerimaanBukuBank extends BaseBuktiPenerimaanBukuBank
{
    const SCENARIO_FOR_SETORAN_KASIR = 'scenario_for_setoran_kasir';
    const SCENARIO_FOR_INVOICES = 'scenario_for_invoices';

    const BALANCE_MATCH = 'match';
    const BALANCE_DEBIT = 'debit';
    const BALANCE_CREDIT = 'credit';

    const DANA_DARI_SETORAN_KASIR = 'setoran_kasir';
    const DANA_DARI_INVOICE = 'pembayaran_invoice';

    public array $invoiceInvoice = [];
    public array $setoranKasirKasir = [];
    public ?string $jumlahSeharusnya = null;


    public ?string $balance = null;
    public ?string $sumberDana = null;
    public ?array $referensiPenerimaan = null;

    public static function optsBalance(): array
    {
        return [
            self::BALANCE_MATCH => 'Match',
            self::BALANCE_DEBIT => 'Debit',
            self::BALANCE_CREDIT => 'Credit',
        ];
    }

    public function afterFind(): void
    {
        parent::afterFind();

        if ($this->setoranKasirs) {

            $this->sumberDana = ucwords(Inflector::humanize(static::DANA_DARI_SETORAN_KASIR));
            $this->referensiPenerimaan['businessProcess'] =  ucwords(Inflector::humanize(static::DANA_DARI_SETORAN_KASIR));
            foreach ($this->setoranKasirs as $setoranKasir) {
                $this->referensiPenerimaan['data'][] = [
                    'setoranKasir' => $setoranKasir->reference_number,
                    'tanggalSetoran' => $setoranKasir->tanggal_setoran,
                    'customer' => $setoranKasir->staff_name,
                    'total' => $setoranKasir->total,
                ];
                $this->jumlahSeharusnya += $setoranKasir->total;

            }
            $this->setBalance();
        }

        if ($this->invoices) {

            $this->sumberDana = ucwords(Inflector::humanize(static::DANA_DARI_INVOICE));
            $this->referensiPenerimaan['businessProcess'] =  ucwords(Inflector::humanize(static::DANA_DARI_INVOICE));

            foreach ($this->invoices as $invoice) {
                $this->referensiPenerimaan['data'][] = [
                    'invoice' => $invoice->reference_number,
                    'tanggalInvoice' => $invoice->tanggal_invoice,
                    'customer' => $invoice->customer->nama,
                    'total' =>$invoice->total
                ];

                $this->jumlahSeharusnya += $invoice->total;
            }

            $this->setBalance();
        }

    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
           'jumlah_setor' => 'Setor',
           'jumlahSeharusnya' => 'Seharusnya',
           'rekening_saya_id' => 'Rekening Saya',
        ]);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            # custom behaviors,
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'reference_number', // required
                'value' => '?' . '/BP-IN-BB/' . date('Y'), // format auto number. '?' will be replaced with generated number
                'digit' => 4
            ],
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['customer_id',
                'rekening_saya_id',
                'jenis_transfer_id',
                'nomor_transaksi_transfer',
                'tanggal_transaksi_transfer',
                'jumlah_setor',
                'invoiceInvoice'
            ], 'required', 'on' => self::SCENARIO_FOR_INVOICES],
            [['customer_id',
                'rekening_saya_id',
                'jenis_transfer_id',
                'nomor_transaksi_transfer',
                'tanggal_transaksi_transfer',
                'jumlah_setor',
                'setoranKasirKasir'
            ], 'required', 'on' => self::SCENARIO_FOR_SETORAN_KASIR],
        ]);
    }

    public function saveForInvoices(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        // update case
        $setNull = [];
        if(!$this->isNewRecord) {
            $oldInvoice = ArrayHelper::map($this->invoices, 'id', 'id');
            $setNull = array_diff($oldInvoice, $this->invoiceInvoice);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($flag = $this->save(false)) {
                if (!empty($setNull)) {
                    Invoice::updateAll(['invoice.bukti_penerimaan_buku_bank_id' => null],[ 'id' => $setNull]);
                }

                foreach ($this->invoiceInvoice as $invoiceID) {
                    if ($invoice = Invoice::findOne($invoiceID)) {
                        if (!$flag) break;
                        $invoice->bukti_penerimaan_buku_bank_id = $this->id;
                        $flag = $invoice->save(false);
                    } else {
                        $flag = false;
                        break;
                    }
                }
            }

            if ($flag) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }
        return false;
    }

    public function saveForSetoranKasir(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        // update case
        $setNull = [];
        if(!$this->isNewRecord) {
            $oldSetoranKasir = ArrayHelper::map($this->setoranKasirs, 'id', 'id');
            $setNull = array_diff($oldSetoranKasir, $this->setoranKasirKasir);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->save(false)) {

                if (!empty($setNull)) {
                    SetoranKasir::updateAll(['setoran_kasir.bukti_penerimaan_buku_bank_id' => null],[ 'id' => $setNull]);
                }

                foreach ($this->setoranKasirKasir as $setoranKasirID) {
                    if ($setoranKasir = SetoranKasir::findOne($setoranKasirID)) {
                        if (!$flag) break;
                        $setoranKasir->bukti_penerimaan_buku_bank_id = $this->id;
                        $flag = $setoranKasir->save(false);
                    } else {
                        $flag = false;
                        break;
                    }
                }
            }
            if ($flag) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }
        return false;
    }

    public function getBalance($asHtml = false): ?string
    {
        if ($asHtml) {
            switch ($this->balance) {
                case static::BALANCE_MATCH:
                    return Html::tag('span', ucfirst($this->balance), ['class' => 'badge bg-primary']);
                case static::BALANCE_DEBIT:
                    return Html::tag('span', ucfirst($this->balance), ['class' => 'badge bg-success']);
                case static::BALANCE_CREDIT:
                    return Html::tag('span', ucfirst($this->balance), ['class' => 'badge bg-warning']);
                default:
                    break;
            }
        }
        return $this->balance;
    }

    private function setBalance(): void
    {
        if ($this->jumlahSeharusnya == $this->jumlah_setor) {
            $this->balance = static::BALANCE_MATCH;
        }

        if ((int)$this->jumlahSeharusnya > (int)$this->jumlah_setor) {
            $this->balance = static::BALANCE_DEBIT;
        }

        if ((int)$this->jumlahSeharusnya < (int)$this->jumlah_setor) {
            $this->balance = static::BALANCE_CREDIT;
        }
    }

    public function getUpdateUrl(): array|string
    {
        if ($this->invoices) {
            return ['bukti-penerimaan-buku-bank/update-for-invoices', 'id' => $this->id];
        }
        if ($this->setoranKasirs) {
            return  ['bukti-penerimaan-buku-bank/update-for-setoran-kasir', 'id' => $this->id];
        }
        return '';
    }

    /**
     * @return $this
     */
    public function getNext()
    {
        return $this->find()->where(['>', 'id', $this->id])->one();
    }

    /**
     * @return $this
     */
    public function getPrevious()
    {
        return $this->find()->where(['<', 'id', $this->id])->orderBy('id desc')->one();
    }

}
