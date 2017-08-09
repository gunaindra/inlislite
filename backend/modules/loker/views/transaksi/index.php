<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;


use common\models\MasterJenisIdentitas;
use common\models\MasterUangJaminan;
use common\models\MasterLoker;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\LockersSearch $searchModel
 */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lockers-index">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?php // echo Html::a('Create Lockers', ['create'], ['class' => 'btn btn-success']) ;  ?>
	</p>

	<?php Pjax::begin(); 


	if ($status == "peminjaman") {
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'toolbar'=> [
				['content'=>
					 \common\components\PageSize::widget(
						[
							'template'=> '{label} <div class="col-sm-8" style="width:175px">{list}</div>',
							'label'=>'Tampilkan',
							'labelOptions'=>[
								'class'=>'col-sm-4 control-label',
								'style'=>[
									'width'=> '75px',
									'margin'=> '0px',
									'padding'=> '0px',
								]

							],
							'sizes'=>Yii::$app->params['pageSize'],
							'options'=>[
								'id'=>'aa',
								'class'=>'form-control'
							]
						]
					 )

				],

				'{toggleData}',
				'{export}',
			],
			'filterSelector' => 'select[name="per-page"]',
			'filterModel' => $searchModel,
			'columns' => [
			
				['class' => 'yii\grid\SerialColumn'],

				'No_pinjaman',
				'no_member',
				// 'no_identitas',
				// 'jenis_jaminan',
				
				[
					'attribute'=>'jenis_jaminan',
					'value'=> function($model){
						// $jenisID = MasterLoker::findOne(['ID'=>$model->loker_id]);
						return $model->jenis_jaminan.' - '.$model->uangJaminan['Name'].' '.$model->jenisIdentitas['Nama'];
					},
				],          
				// [
	   //              'attribute'=>'id_jamin_idt',
	   //              'value'=>'jenisIdentitas.Nama',
	   //          ],
			
				// [
	   //              'attribute'=>'id_jamin_uang',
	   //              'value'=>'uangJaminan.Name',
	   //          ],
				
				[
					'attribute'=>'loker_id',
					'value'=>'loker.Name',
				],
				
			   //'loker_id',
			   // ['attribute'=>'loker_id','value'=> function($model){
					// $jenisID = MasterLoker::findOne(['ID'=>$model->loker_id]);
					// return $jenisID['Name'];
				// },'label'=>'Loker'], 
			   	[
			   		'attribute'=>'tanggal_pinjam',
			   		// 'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']
	                'value'=>function($model)
	                {
                    	$time = strtotime($model->tanggal_pinjam);
                    	return date('d-m-Y H:i:s',$time);
                	},
	               	'contentOptions'=>['style'=>'width: 200px;'],
                	'filterType'=>GridView::FILTER_DATE,
                	'filterWidgetOptions'=>[
	               	 	'pluginOptions' => [
		               	 	'format' => 'dd-mm-yyyy',
						]
		            ],
			   	],

			   
			   //'id_pelanggaran_locker', 
			   
				[
					'attribute'=>'id_pelanggaran_locker',
					'value'=>'pelanggaran.jenis_pelanggaran',
				],
				

				[
					'class' => 'yii\grid\ActionColumn',
					'contentOptions'=>['style'=>'max-width: 200px;'],
					'template' => '{view}',
					'buttons' => [
											  
					'view' => function ($url, $model) {
										return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Detail', Yii::$app->urlManager->createUrl(['loker/transaksi/view','id' => $model->ID,'edit'=>'t']), [
														'title' => Yii::t('app', 'View'),
														'class' => 'btn btn-success btn-sm',
														'data' => [
															
															'method' => 'post',
														],
													  ]);},

					],
				],
			],
			'responsive'=>true,
			'hover'=>true,
			'condensed'=>true,
			'floatHeader'=>false,

			'panel' => [
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
				'type'=>'info',
				'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app','Reset List'), ['daftar-peminjaman'], ['class' => 'btn btn-info']),
				'showFooter'=>false
			],
		]); 
	} else {
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'toolbar'=> [
				['content'=>
					 \common\components\PageSize::widget(
						[
							'template'=> '{label} <div class="col-sm-8" style="width:175px">{list}</div>',
							'label'=>'Tampilkan',
							'labelOptions'=>[
								'class'=>'col-sm-4 control-label',
								'style'=>[
									'width'=> '75px',
									'margin'=> '0px',
									'padding'=> '0px',
								]

							],
							'sizes'=>Yii::$app->params['pageSize'],
							'options'=>[
								'id'=>'aa',
								'class'=>'form-control'
							]
						]
					 )

				],

				'{toggleData}',
				'{export}',
			],
			'filterSelector' => 'select[name="per-page"]',
			'filterModel' => $searchModel,
			'columns' => [
			
				['class' => 'yii\grid\SerialColumn'],

				'No_pinjaman',
				'no_member',
				// 'no_identitas',
				// 'jenis_jaminan',
				
				[
					'attribute'=>'jenis_jaminan',
					'value'=> function($model){
						// $jenisID = MasterLoker::findOne(['ID'=>$model->loker_id]);
						return $model->jenis_jaminan.' - '.$model->uangJaminan['Name'].' '.$model->jenisIdentitas['Nama'];
					},
				],			
				// [
	   //              'attribute'=>'id_jamin_idt',
	   //              'value'=>'jenisIdentitas.Nama',
	   //          ],
			
				// [
	   //              'attribute'=>'id_jamin_uang',
	   //              'value'=>'uangJaminan.Name',
	   //          ],
				
				[
					'attribute'=>'loker_id',
					'value'=>'loker.Name',
				],
				
			   //'loker_id',
			   // ['attribute'=>'loker_id','value'=> function($model){
					// $jenisID = MasterLoker::findOne(['ID'=>$model->loker_id]);
					// return $jenisID['Name'];
				// },'label'=>'Loker'], 
			   	[
			   		'attribute'=>'tanggal_pinjam',
			   		// 'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']
	                'value'=>function($model)
	                {
                    	$time = strtotime($model->tanggal_pinjam);
                    	return date('d-m-Y H:i:s',$time);
                	},
	               	'contentOptions'=>['style'=>'width: 200px;'],
                	'filterType'=>GridView::FILTER_DATE,
                	'filterWidgetOptions'=>[
	               	 	'pluginOptions' => [
		               	 	'format' => 'dd-mm-yyyy',
						]
		            ],
			   	],


			   	[
					'attribute'=>'tanggal_kembali',
					// 'format'=>[
					// 	'datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'
					// ]
	                'value'=>function($model)
	                {
                    	$time = strtotime($model->tanggal_kembali);
                    	return date('d-m-Y H:i:s',$time);
                	},
	               	'contentOptions'=>['style'=>'width: 200px;'],
                	'filterType'=>GridView::FILTER_DATE,
                	'filterWidgetOptions'=>[
	               	 	'pluginOptions' => [
		               	 	'format' => 'dd-mm-yyyy',
						]
		            ],
				], 
			   //'id_pelanggaran_locker', 
			   
				[
					'attribute'=>'id_pelanggaran_locker',
					'value'=>'pelanggaran.jenis_pelanggaran',
				],
				

				[
					'class' => 'yii\grid\ActionColumn',
					'contentOptions'=>['style'=>'max-width: 200px;'],
					'template' => '{view}',
					'buttons' => [
											  
					'view' => function ($url, $model) {
										return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Detail', Yii::$app->urlManager->createUrl(['loker/transaksi/view','id' => $model->ID,'edit'=>'t']), [
														'title' => Yii::t('app', 'View'),
														'class' => 'btn btn-success btn-sm',
														'data' => [
															
															'method' => 'post',
														],
													  ]);},

					],
				],
			],
			'responsive'=>true,
			'hover'=>true,
			'condensed'=>true,
			'floatHeader'=>false,

			'panel' => [
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
				'type'=>'info',
				'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app','Reset List'), ['daftar-pengembalian'], ['class' => 'btn btn-info']),
				'showFooter'=>false
			],
		]); 
	}
	



	Pjax::end(); ?>

</div>
