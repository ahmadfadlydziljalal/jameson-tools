<?php

namespace app\models;

use \app\models\base\JobOrderBill as BaseJobOrderBill;

/**
 * This is the model class for table "job_order_bill".
 */
class JobOrderBill extends BaseJobOrderBill
{

    public ?string $referenceNumber = null;

    public function getTotalPrice(): float|int
    {
        $total = 0;
        foreach ($this->jobOrderBillDetails as $jobOrderBillDetail) {
            $total +=  $jobOrderBillDetail->quantity * $jobOrderBillDetail->price;
        }
        return $total;
    }
}
