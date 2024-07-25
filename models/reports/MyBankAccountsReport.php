<?php

namespace app\models\reports;

use app\components\helpers\ArrayHelper;
use app\models\form\BukuBankReportPerSpecificDate;
use app\models\form\MutasiKasPettyCashReportPerSpecificDate;
use app\models\Rekening;
use Yii;
use yii\base\Model;

class MyBankAccountsReport extends Model
{

    public ?string $date = null;

    /** @var $bankAccounts BukuBankReportPerSpecificDate[] */
    public array $bankAccounts = [];

    /** @var $mutasiKasPettyCashReportPerSpecificDate MutasiKasPettyCashReportPerSpecificDate|null */
    public ?MutasiKasPettyCashReportPerSpecificDate $mutasiKasPettyCashReportPerSpecificDate = null;

    private ?string $key = null;

    public function getKey(): ?string{
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();
        $this->date = date('Y-m-d');
        $this->setBankAccounts();
        $this->setPettyCash();
        $this->key = self::class . '-' . time();
        Yii::$app->cache->set($this->key, $this);
    }

    /**
     * @param bool $isFormatted
     * @return float|int|string|null
     */
    public function getTotalInitNominalBankAccounts(bool $isFormatted = false): float|int|string|null
    {
        $total = array_sum(ArrayHelper::getColumn($this->bankAccounts, 'startingBalance'));
        return $isFormatted ? Yii::$app->formatter->asDecimal($total, 2) : $total;
    }

    /**
     * @param bool $isFormatted
     * @return float|int|string|null
     */
    public function getTotalDebitBankAccounts(bool $isFormatted = false): float|int|string|null
    {
        $total = array_sum(ArrayHelper::getColumn($this->bankAccounts, 'sumDebit'));
        return $isFormatted ? Yii::$app->formatter->asDecimal($total, 2) : $total;
    }

    /**
     * @param bool $isFormatted
     * @return float|int|string|null
     */
    public function getTotalCreditBankAccounts(bool $isFormatted = false): float|int|string|null
    {
        $total = array_sum(ArrayHelper::getColumn($this->bankAccounts, 'sumCredit'));
        return $isFormatted ? Yii::$app->formatter->asDecimal($total, 2) : $total;
    }

    /**
     * @param bool $isFormatted
     * @return float|int|string|null
     */
    public function getTotalEndingBalanceBankAccounts(bool $isFormatted = false): float|int|string|null
    {
        $total = array_sum(ArrayHelper::getColumn($this->bankAccounts, 'endingBalance'));
        return $isFormatted ? Yii::$app->formatter->asDecimal($total, 2) : $total;
    }

    /**
     * @param bool $isFormatted
     * @return float|int|string
     */
    public function getTotalAllOfEndingBalance(bool $isFormatted = true): float|int|string
    {
        $total = abs($this->getTotalEndingBalanceBankAccounts()) + abs($this->mutasiKasPettyCashReportPerSpecificDate->getEndingBalance());
        return $isFormatted ? Yii::$app->formatter->asDecimal($total, 2) : $total;
    }

    /**
     * @return void
     */
    private function setBankAccounts(): void
    {
        $this->bankAccounts = Rekening::find()->actualBalanceOnlyTokoSaya($this->date);
    }

    /**
     * @return void
     */
    private function setPettyCash(): void
    {
        $mutasiKas = new MutasiKasPettyCashReportPerSpecificDate([
            'date' => $this->date
        ]);
        $mutasiKas->find();
        $this->mutasiKasPettyCashReportPerSpecificDate = $mutasiKas;
    }


}