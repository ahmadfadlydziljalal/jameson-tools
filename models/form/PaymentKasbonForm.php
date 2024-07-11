<?php

namespace app\models\form;

use yii\base\Model;

class PaymentKasbonForm extends Model
{
    public ?string $id = null;
    public ?string $change = null;

    public function rules()
    {
        return [
            [['id', 'change'], 'required'],
        ];
    }

}