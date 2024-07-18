<?php

namespace app\models;

use \app\models\base\JobOrderBillDetail as BaseJobOrderBillDetail;

/**
 * This is the model class for table "job_order_bill_detail".
 */
class JobOrderBillDetail extends BaseJobOrderBillDetail
{

    public function getTotal()
    {
        return $this->quantity * $this->price;
    }
}
