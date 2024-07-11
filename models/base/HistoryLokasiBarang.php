<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "history_lokasi_barang".
 *
 * @property integer $id
 * @property integer $barang_id
 * @property string $nomor
 * @property integer $card_id
 * @property integer $tanda_terima_barang_detail_id
 * @property integer $claim_petty_cash_nota_detail_id
 * @property integer $quotation_delivery_receipt_detail_id
 * @property integer $tipe_pergerakan_id
 * @property integer $step
 * @property string $quantity
 * @property string $block
 * @property string $rak
 * @property string $tier
 * @property string $row
 * @property string $catatan
 * @property integer $depend_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property \app\models\Barang $barang
 * @property \app\models\Card $card
 * @property \app\models\ClaimPettyCashNotaDetail $claimPettyCashNotaDetail
 * @property \app\models\HistoryLokasiBarang $depend
 * @property \app\models\HistoryLokasiBarang[] $historyLokasiBarangs
 * @property \app\models\QuotationDeliveryReceiptDetail $quotationDeliveryReceiptDetail
 * @property \app\models\TandaTerimaBarangDetail $tandaTerimaBarangDetail
 * @property \app\models\Status $tipePergerakan
 * @property string $aliasModel
 */
abstract class HistoryLokasiBarang extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_lokasi_barang';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['barang_id', 'card_id', 'tanda_terima_barang_detail_id', 'claim_petty_cash_nota_detail_id', 'quotation_delivery_receipt_detail_id', 'tipe_pergerakan_id', 'step', 'depend_id'], 'integer'],
            [['card_id', 'quantity', 'block', 'rak', 'tier', 'row'], 'required'],
            [['quantity'], 'number'],
            [['catatan'], 'string'],
            [['nomor'], 'string', 'max' => 255],
            [['block', 'rak', 'tier', 'row'], 'string', 'max' => 8],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Barang::class, 'targetAttribute' => ['barang_id' => 'id']],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['card_id' => 'id']],
            [['depend_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\HistoryLokasiBarang::class, 'targetAttribute' => ['depend_id' => 'id']],
            [['quotation_delivery_receipt_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\QuotationDeliveryReceiptDetail::class, 'targetAttribute' => ['quotation_delivery_receipt_detail_id' => 'id']],
            [['tipe_pergerakan_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Status::class, 'targetAttribute' => ['tipe_pergerakan_id' => 'id']],
            [['tanda_terima_barang_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\TandaTerimaBarangDetail::class, 'targetAttribute' => ['tanda_terima_barang_detail_id' => 'id']],
            [['claim_petty_cash_nota_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\ClaimPettyCashNotaDetail::class, 'targetAttribute' => ['claim_petty_cash_nota_detail_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barang_id' => 'Barang ID',
            'nomor' => 'Nomor',
            'card_id' => 'Card ID',
            'tanda_terima_barang_detail_id' => 'Tanda Terima Barang Detail ID',
            'claim_petty_cash_nota_detail_id' => 'Claim Petty Cash Nota Detail ID',
            'quotation_delivery_receipt_detail_id' => 'Quotation Delivery Receipt Detail ID',
            'tipe_pergerakan_id' => 'Tipe Pergerakan ID',
            'step' => 'Step',
            'quantity' => 'Quantity',
            'block' => 'Block',
            'rak' => 'Rak',
            'tier' => 'Tier',
            'row' => 'Row',
            'catatan' => 'Catatan',
            'depend_id' => 'Depend ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'barang_id' => 'Barang ID difungsikan hanya untuk meng-handle saat pertama kali sistem diterapkan',
            'card_id' => 'Card yang bertindak sebagai warehouse',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(\app\models\Barang::class, ['id' => 'barang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(\app\models\Card::class, ['id' => 'card_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimPettyCashNotaDetail()
    {
        return $this->hasOne(\app\models\ClaimPettyCashNotaDetail::class, ['id' => 'claim_petty_cash_nota_detail_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepend()
    {
        return $this->hasOne(\app\models\HistoryLokasiBarang::class, ['id' => 'depend_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryLokasiBarangs()
    {
        return $this->hasMany(\app\models\HistoryLokasiBarang::class, ['depend_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationDeliveryReceiptDetail()
    {
        return $this->hasOne(\app\models\QuotationDeliveryReceiptDetail::class, ['id' => 'quotation_delivery_receipt_detail_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTandaTerimaBarangDetail()
    {
        return $this->hasOne(\app\models\TandaTerimaBarangDetail::class, ['id' => 'tanda_terima_barang_detail_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipePergerakan()
    {
        return $this->hasOne(\app\models\Status::class, ['id' => 'tipe_pergerakan_id']);
    }




}
