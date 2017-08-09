<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MemberPerpanjangan;
use common\models\Members;

/**
 * MemberPerpanjanganSearch represents the model behind the search form about `common\models\MemberPerpanjangan`.
 */
class MemberPerpanjanganSearch extends MemberPerpanjangan
{
    public function rules()
    {
        return [
            [['ID', 'Member_id', 'Tanggal', 'Keterangan', 'CreateDate', 'CreateTerminal', 'UpdateDate', 'UpdateTerminal'], 'safe'],
            [['Biaya'], 'number'],
            [['IsLunas'], 'boolean'],
            [['CreateBy', 'UpdateBy'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MemberPerpanjangan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//        if (!($this->load($params) && $this->validate())) {
//            return $dataProvider;
//        }

        $query->andFilterWhere([
            'Tanggal' => $this->Tanggal,
            'Biaya' => $this->Biaya,
            'IsLunas' => $this->IsLunas,
            'CreateBy' => $this->CreateBy,
            'CreateDate' => $this->CreateDate,
            'UpdateBy' => $this->UpdateBy,
            'UpdateDate' => $this->UpdateDate,
            'Member_id' => $params['MemberPerpanjanganSearch']['Member_id'],
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'Member_id', $this->Member_id])
            ->andFilterWhere(['like', 'Keterangan', $this->Keterangan])
            ->andFilterWhere(['like', 'CreateTerminal', $this->CreateTerminal])
            ->andFilterWhere(['like', 'UpdateTerminal', $this->UpdateTerminal]);

        return $dataProvider;
    }
    
    public function getMemberID($noAnggota){
        $query = Members::find()->where(['MemberNo'=>$noAnggota])->one() ;
        return $query->ID;
        
    }
}
