<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\MasterKependudukanSearch $searchModel
 */

?>

<?php  //echo $this->render('_searchPenduduk', ['model' => $searchModel,'rules' => $rules]); ?>


<div class="table-responsive">
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'responsive'=>true,
        //'hover'=>true,
        
        'filterSelector' => 'select[name="per-page"]',
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'MemberNo',
            [
                         //'label'=>'Nama',
                         'format'=>'raw',
                         'attribute'=>'Fullname',
                         'value' => function($data){
                             $url = Url::to(['update','id'=>$data->Fullname]);
                             return Html::a($data->Fullname, '#',
                                [
                                'title' => $data->Fullname,
                                'onclick'=>"
                                    $.ajax({
                                        type     :'POST',
                                        cache    : false,
                                        url  : 'bind-penduduk?id=".$data->ID."',
                                        success  : function(response) {
                                            var data =  $.parseJSON(response);
                                            //alert(data.id);
                                            $('#members-identityno').val(data.nik);
                                            $('#dynamicmodel-fullname').val(data.Fullname);
                                            //$('#members-phone').val(data.Phone);
                                            $('#outbox-destinationnumber').val(data.Phone);
    
                                            $('#myModal').modal('hide');
                                        }
                                    });return false;",
                                ]
                                ); 
                         }
            ],
            //'namalengkap',
            'PlaceOfBirth',
            'DateOfBirth', 
            'Address', 
            'Phone',
            'IdentityType_id',
            'IdentityNo',
            'MotherMaidenName',
            'Email',
            'InstitutionName',
            'InstitutionAddress',
            'InstitutionPhone', 


        ],
        
    ]);  ?>

</div>

