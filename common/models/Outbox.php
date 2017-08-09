<?php

namespace common\models;

use Yii;
use \common\models\base\Outbox as BaseOutbox;

/**
 * This is the model class for table "outbox".
 */
class Outbox extends BaseOutbox
{



/**
     * @inheritdoc
     * @return type array
     */ 
    public function behaviors()
    {
        return [

        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['DestinationNumber','TextDecoded'], 'required'],

  
        ];
    }

        /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DestinationNumber' => Yii::t('app', 'Destination Number'),
            'TextDecoded' => Yii::t('app', 'Text Decoded'),
        ];
    }


}
