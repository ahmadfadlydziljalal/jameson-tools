<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\Invoice as BaseInvoice;
use Yii;

/**
 * This is the model class for table "invoice".
 */
class Invoice extends BaseInvoice
{

    public mixed $total = 0;

    public function afterFind()
    {
        parent::afterFind();
        $this->total = $this->countTotal();
    }

    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'reference_number',
                    'value' => '?' . ' / INV / AI / VI / ' . date('Y'), // format auto number. '?' will be replaced with generated number
                    'digit' => 3
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'tanggal_invoice' => 'Tgl. Invoice',
        ]);
    }

    protected function countTotal(){
        $total = 0;
        foreach ($this->invoiceDetails as $invoiceDetail) {
            $total += $invoiceDetail->jumlahHarga();
        }
        return $total;
    }

    public function getTotal(bool $format= false): mixed
    {
        return $format ? \Yii::$app->formatter->asDecimal($this->total, 2) : $this->total;
    }

    public function spellOutTotal()
    {
        return Yii::$app->formatter->asSpellout($this->total, 2);
    }



}
