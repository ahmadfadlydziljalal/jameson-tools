<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use \app\models\active_queries\TransaksiBukuBankLainnyaQuery;

/**
 * This is the base-model class for table "transaksi_buku_bank_lainnya".
 *
 * @property integer $id
 * @property string $reference_number
 * @property integer $buku_bank_id
 * @property integer $rekening_id
 * @property integer $card_id
 * @property integer $jenis_pendapatan_id
 * @property integer $jenis_biaya_id
 * @property string $nominal
 * @property string $keterangan
 *
 * @property \app\models\BukuBank $bukuBank
 * @property \app\models\Card $card
 * @property \app\models\JenisBiaya $jenisBiaya
 * @property \app\models\JenisPendapatan $jenisPendapatan
 * @property \app\models\Rekening $rekening
 */
abstract class TransaksiBukuBankLainnya extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi_buku_bank_lainnya';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['buku_bank_id', 'rekening_id', 'card_id', 'jenis_pendapatan_id', 'jenis_biaya_id'], 'integer'],
            [['rekening_id', 'card_id'], 'required'],
            [['nominal'], 'number'],
            [['keterangan'], 'string'],
            [['reference_number'], 'string', 'max' => 50],
            [['buku_bank_id'], 'unique'],
            [['rekening_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Rekening::class, 'targetAttribute' => ['rekening_id' => 'id']],
            [['buku_bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\BukuBank::class, 'targetAttribute' => ['buku_bank_id' => 'id']],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['card_id' => 'id']],
            [['jenis_pendapatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\JenisPendapatan::class, 'targetAttribute' => ['jenis_pendapatan_id' => 'id']],
            [['jenis_biaya_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\JenisBiaya::class, 'targetAttribute' => ['jenis_biaya_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'reference_number' => 'Reference Number',
            'buku_bank_id' => 'Buku Bank ID',
            'rekening_id' => 'Rekening ID',
            'card_id' => 'Card ID',
            'jenis_pendapatan_id' => 'Jenis Pendapatan ID',
            'jenis_biaya_id' => 'Jenis Biaya ID',
            'nominal' => 'Nominal',
            'keterangan' => 'Keterangan',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBukuBank()
    {
        return $this->hasOne(\app\models\BukuBank::class, ['id' => 'buku_bank_id']);
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
    public function getJenisBiaya()
    {
        return $this->hasOne(\app\models\JenisBiaya::class, ['id' => 'jenis_biaya_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenisPendapatan()
    {
        return $this->hasOne(\app\models\JenisPendapatan::class, ['id' => 'jenis_pendapatan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRekening()
    {
        return $this->hasOne(\app\models\Rekening::class, ['id' => 'rekening_id']);
    }

    /**
     * @inheritdoc
     * @return TransaksiBukuBankLainnyaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransaksiBukuBankLainnyaQuery(static::class);
    }
}
