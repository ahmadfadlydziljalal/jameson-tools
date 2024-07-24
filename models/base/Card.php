<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use \app\models\active_queries\CardQuery;

/**
 * This is the base-model class for table "card".
 *
 * @property integer $id
 * @property string $nama
 * @property string $kode
 * @property string $alamat
 * @property string $npwp
 * @property integer $mata_uang_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property \app\models\BarangSatuan[] $barangSatuans
 * @property \app\models\BuktiPenerimaanBukuBank[] $buktiPenerimaanBukuBanks
 * @property \app\models\BuktiPengeluaranBukuBank[] $buktiPengeluaranBukuBanks
 * @property \app\models\CardBelongsType[] $cardBelongsTypes
 * @property \app\models\CardOwnEquipment[] $cardOwnEquipments
 * @property \app\models\CardPersonInCharge[] $cardPersonInCharges
 * @property \app\models\ClaimPettyCashNota[] $claimPettyCashNotas
 * @property \app\models\ClaimPettyCash[] $claimPettyCashes
 * @property \app\models\ClaimPettyCash[] $claimPettyCashes0
 * @property \app\models\ClaimPettyCash[] $claimPettyCashes1
 * @property \app\models\FakturDetail[] $fakturDetails
 * @property \app\models\Faktur[] $fakturs
 * @property \app\models\Faktur[] $fakturs0
 * @property \app\models\HistoryLokasiBarang[] $historyLokasiBarangs
 * @property \app\models\Inventaris[] $inventaris
 * @property \app\models\InventarisLaporanPerbaikanDetail[] $inventarisLaporanPerbaikanDetails
 * @property \app\models\InventarisLaporanPerbaikanMaster[] $inventarisLaporanPerbaikanMasters
 * @property \app\models\InventarisLaporanPerbaikanMaster[] $inventarisLaporanPerbaikanMasters0
 * @property \app\models\InventarisLaporanPerbaikanMaster[] $inventarisLaporanPerbaikanMasters1
 * @property \app\models\Invoice[] $invoices
 * @property \app\models\JobOrderBill[] $jobOrderBills
 * @property \app\models\JobOrderDetailCashAdvance[] $jobOrderDetailCashAdvances
 * @property \app\models\JobOrderDetailPettyCash[] $jobOrderDetailPettyCashes
 * @property \app\models\JobOrder[] $jobOrders
 * @property \app\models\JobOrder[] $jobOrders0
 * @property \app\models\MataUang $mataUang
 * @property \app\models\MaterialRequisitionDetailPenawaran[] $materialRequisitionDetailPenawarans
 * @property \app\models\MaterialRequisitionDetail[] $materialRequisitionDetails
 * @property \app\models\MaterialRequisition[] $materialRequisitions
 * @property \app\models\MaterialRequisition[] $materialRequisitions0
 * @property \app\models\MaterialRequisition[] $materialRequisitions1
 * @property \app\models\PettyCash $pettyCash
 * @property \app\models\PurchaseOrder[] $purchaseOrders
 * @property \app\models\PurchaseOrder[] $purchaseOrders0
 * @property \app\models\QuotationFormJobMekanik[] $quotationFormJobMekaniks
 * @property \app\models\QuotationFormJob[] $quotationFormJobs
 * @property \app\models\Quotation[] $quotations
 * @property \app\models\Quotation[] $quotations0
 * @property \app\models\Rekening[] $rekenings
 * @property \app\models\TandaTerimaBarang[] $tandaTerimaBarangs
 * @property \app\models\TransaksiBukuBankLainnya[] $transaksiBukuBankLainnyas
 * @property \app\models\TransaksiMutasiKasPettyCashLainnya[] $transaksiMutasiKasPettyCashLainnyas
 */
abstract class Card extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['blameable'] = [
            'class' => BlameableBehavior::class,
        ];
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
                        ];
        
    return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['nama', 'alamat'], 'required'],
            [['mata_uang_id'], 'integer'],
            [['nama', 'alamat'], 'string', 'max' => 255],
            [['kode'], 'string', 'max' => 50],
            [['npwp'], 'string', 'max' => 24],
            [['mata_uang_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\MataUang::class, 'targetAttribute' => ['mata_uang_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'nama' => 'Nama',
            'kode' => 'Kode',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'alamat' => 'Alamat',
            'npwp' => 'Npwp',
            'mata_uang_id' => 'Mata Uang ID',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangSatuans()
    {
        return $this->hasMany(\app\models\BarangSatuan::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuktiPenerimaanBukuBanks()
    {
        return $this->hasMany(\app\models\BuktiPenerimaanBukuBank::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuktiPengeluaranBukuBanks()
    {
        return $this->hasMany(\app\models\BuktiPengeluaranBukuBank::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardBelongsTypes()
    {
        return $this->hasMany(\app\models\CardBelongsType::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardOwnEquipments()
    {
        return $this->hasMany(\app\models\CardOwnEquipment::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardPersonInCharges()
    {
        return $this->hasMany(\app\models\CardPersonInCharge::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimPettyCashNotas()
    {
        return $this->hasMany(\app\models\ClaimPettyCashNota::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimPettyCashes()
    {
        return $this->hasMany(\app\models\ClaimPettyCash::class, ['acknowledge_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimPettyCashes0()
    {
        return $this->hasMany(\app\models\ClaimPettyCash::class, ['approved_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimPettyCashes1()
    {
        return $this->hasMany(\app\models\ClaimPettyCash::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFakturDetails()
    {
        return $this->hasMany(\app\models\FakturDetail::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFakturs()
    {
        return $this->hasMany(\app\models\Faktur::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFakturs0()
    {
        return $this->hasMany(\app\models\Faktur::class, ['toko_saya_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryLokasiBarangs()
    {
        return $this->hasMany(\app\models\HistoryLokasiBarang::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventaris()
    {
        return $this->hasMany(\app\models\Inventaris::class, ['location_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarisLaporanPerbaikanDetails()
    {
        return $this->hasMany(\app\models\InventarisLaporanPerbaikanDetail::class, ['last_location_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarisLaporanPerbaikanMasters()
    {
        return $this->hasMany(\app\models\InventarisLaporanPerbaikanMaster::class, ['approved_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarisLaporanPerbaikanMasters0()
    {
        return $this->hasMany(\app\models\InventarisLaporanPerbaikanMaster::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarisLaporanPerbaikanMasters1()
    {
        return $this->hasMany(\app\models\InventarisLaporanPerbaikanMaster::class, ['known_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(\app\models\Invoice::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrderBills()
    {
        return $this->hasMany(\app\models\JobOrderBill::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrderDetailCashAdvances()
    {
        return $this->hasMany(\app\models\JobOrderDetailCashAdvance::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrderDetailPettyCashes()
    {
        return $this->hasMany(\app\models\JobOrderDetailPettyCash::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrders()
    {
        return $this->hasMany(\app\models\JobOrder::class, ['main_customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrders0()
    {
        return $this->hasMany(\app\models\JobOrder::class, ['main_vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMataUang()
    {
        return $this->hasOne(\app\models\MataUang::class, ['id' => 'mata_uang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitionDetailPenawarans()
    {
        return $this->hasMany(\app\models\MaterialRequisitionDetailPenawaran::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitionDetails()
    {
        return $this->hasMany(\app\models\MaterialRequisitionDetail::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitions()
    {
        return $this->hasMany(\app\models\MaterialRequisition::class, ['acknowledge_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitions0()
    {
        return $this->hasMany(\app\models\MaterialRequisition::class, ['approved_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitions1()
    {
        return $this->hasMany(\app\models\MaterialRequisition::class, ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPettyCash()
    {
        return $this->hasOne(\app\models\PettyCash::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrders()
    {
        return $this->hasMany(\app\models\PurchaseOrder::class, ['acknowledge_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrders0()
    {
        return $this->hasMany(\app\models\PurchaseOrder::class, ['approved_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationFormJobMekaniks()
    {
        return $this->hasMany(\app\models\QuotationFormJobMekanik::class, ['mekanik_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationFormJobs()
    {
        return $this->hasMany(\app\models\QuotationFormJob::class, ['mekanik_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations()
    {
        return $this->hasMany(\app\models\Quotation::class, ['signature_orang_kantor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations0()
    {
        return $this->hasMany(\app\models\Quotation::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRekenings()
    {
        return $this->hasMany(\app\models\Rekening::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTandaTerimaBarangs()
    {
        return $this->hasMany(\app\models\TandaTerimaBarang::class, ['acknowledge_by_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksiBukuBankLainnyas()
    {
        return $this->hasMany(\app\models\TransaksiBukuBankLainnya::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksiMutasiKasPettyCashLainnyas()
    {
        return $this->hasMany(\app\models\TransaksiMutasiKasPettyCashLainnya::class, ['card_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CardQuery(static::class);
    }
}
