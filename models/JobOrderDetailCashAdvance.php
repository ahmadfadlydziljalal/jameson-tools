<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\models\base\JobOrderDetailCashAdvance as BaseJobOrderDetailCashAdvance;
use yii\db\Exception;

/**
 * @property float $cash_advance
 * @property float $kasbon_request
 * This is the model class for table "job_order_detail_cash_advance".
 */
class JobOrderDetailCashAdvance extends BaseJobOrderDetailCashAdvance
{

    public ?string $referenceNumber = null;

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'mata_uang_id' => 'Cur.',
            'cash_advance' => 'Panjar / Cash Advance',
            'jenis_biaya_id' => 'Jenis Biaya',
        ]);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $x = JobOrderDetailCashAdvance::find()->where([
                'job_order_id' => $this->job_order_id
            ])->max('job_order_detail_cash_advance.order');
            $this->order = $x + 1;
        }
        return parent::beforeSave($insert);
    }

    /**
     * Kasbon sudah diberikan kepada orang yang request sejumlah dana tersebut
     * @return bool
     * @throws Exception
     */
    public function markAsPaid(): bool
    {
        $this->cash_advance = $this->kasbon_request;
        $this->kasbon_request = 0;
        return $this->save(false);
    }

    public function reverseMarkAsPaid(): bool
    {
        $this->kasbon_request = $this->cash_advance;
        $this->cash_advance = 0;
        return $this->save(false);
    }

    public function markAsPaidFromBuktiPengeluaranPettyCash($id): bool
    {
        $this->cash_advance = $this->kasbon_request;
        $this->kasbon_request = 0;
        $this->bukti_pengeluaran_petty_cash_id = $id;
        return $this->save(false);
    }

    public function reverseMarkAsPaidFromBuktiPengeluaranPettyCash(): bool
    {
        $this->kasbon_request = $this->cash_advance;
        $this->cash_advance = 0;
        $this->bukti_pengeluaran_petty_cash_id = null;
        return $this->save(false);
    }


    public function isPanjar(): bool
    {
        return $this->cash_advance != 0 and $this->kasbon_request == 0;
    }

    public function markAsPaidFromBuktiPengeluaranBukuBank(int $id): bool
    {

        $this->cash_advance = $this->kasbon_request;
        $this->kasbon_request = 0;

        $this->bukti_pengeluaran_buku_bank_id = $id;
        return $this->save(false);
    }

    public function reverseMarkAsPaidFromBuktiPengeluaranBukuBank()
    {
        $this->kasbon_request = $this->cash_advance;
        $this->cash_advance = 0;
        $this->bukti_pengeluaran_buku_bank_id = null;
        return $this->save(false);
    }

    /**
     * @return string|null
     */
    public function getBuktiPengeluaranReferenceNumber(): ?string
    {
        if ($this->bukti_pengeluaran_petty_cash_id) {
            return $this->buktiPengeluaranPettyCash->reference_number;
        }

        if ($this->bukti_pengeluaran_buku_bank_id) {
            return $this->buktiPengeluaranBukuBank?->reference_number;
        }

        return '';
    }


}
