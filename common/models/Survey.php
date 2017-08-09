<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use inlislite\gii\behaviors\TerminalBehavior;

use \common\models\base\Survey as BaseSurvey;

/**
 * This is the model class for table "Survey".
 */
class Survey extends BaseSurvey
{
	public function attributeLabels()
    {
        return [
		    'ID' => 'ID',
            'NamaSurvey' => 'Nama Survey',
            //'TanggalMulai' => 'Tanggal Mulai',
            //'TanggalSelesai' => 'Tanggal Selesai',
            'IsActive' => 'Is Active',
            'NomorUrut' => 'Nomor Urut',
            'TargetSurvey' => 'Target Survey',
            'HasilSurveyShow' => 'Hasil Survey Show',
            'RedaksiAwal' => 'Redaksi Awal',
            'RedaksiAkhir' => 'Redaksi Akhir',
            'Keterangan' => 'Keterangan',
            'CreateBy' => 'Create By',
            'CreateDate' => 'Create Date',
            'CreateTerminal' => 'Create Terminal',
            'UpdateBy' => 'Update By',
            'UpdateDate' => 'Update Date',
            'UpdateTerminal' => 'Update Terminal',
			'TglMulai' => Yii::t('app', 'TanggalMulai'),
			'TglSelesai' => Yii::t('app', 'TanggalSelesai'),
		
		];
	}
	
    public function behaviors()
    {



        return [
            \common\widgets\nhkey\ActiveRecordHistoryBehavior::className(),
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'CreateDate',
                'updatedAtAttribute' => 'UpdateDate',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'CreateBy',
                'updatedByAttribute' => 'UpdateBy',
            ],
            [
                'class' => TerminalBehavior::className(),
                'createdTerminalAttribute' => 'CreateTerminal',
                'updatedTerminalAttribute' => 'UpdateTerminal',
                'value' => \Yii::$app->request->userIP,
            ],
            [
                'class'=>'common\components\behaviors\DateConverter',
                'physicalFormat'=>'Y-m-d',
                'attributes'=>[
                    'TglMulai' => 'TanggalMulai',
                    'TglSelesai' => 'TanggalSelesai',
                ]
            ],
        ];

    }
}

