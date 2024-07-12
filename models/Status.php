<?php

namespace app\models;

use app\models\base\Status as BaseStatus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "status".
 */
class Status extends BaseStatus
{

   const MATERIAL_REQUISITION_DETAIL_PENAWARAN_STATUS = 'material-requisition-detail-penawaran-status';

   const SECTION_SET_LOKASI_BARANG = 'set-lokasi-barang';

   const SECTION_STATUS_EQUIPMENT_TOOL_REPAIR_REQUEST = 'status-equipment-tool-repair-request';

   const SECTION_KONDISI_EQUIPMENT_TOOL_REPAIR_REQUEST = 'kondisi-equipment-tool-repair-request';


   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
         ]
      );
   }

   public function rules()
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
         ]
      );
   }
}