<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\InvoiceDetail as BaseInvoiceDetail;
use Yii;

/**
 * This is the model class for table "invoice_detail".
 */
class InvoiceDetail extends BaseInvoiceDetail
{

    const SCENARIO_TAGIHAN_BARANG = 'scenario_tagihan_barang';

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
           [['quantity', 'satuan_id','barang_id','harga'], 'required', 'on' => self::SCENARIO_TAGIHAN_BARANG],
        ]);
    }

    public function jumlahHarga($format = false): float|int|string
    {
        $total = $this->quantity * $this->harga;
        return $format ? Yii::$app->formatter->asDecimal($total, 2) : $total;
    }
}
