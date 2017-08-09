<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\grid\GridView;
use kartik\date\DatePicker;

use kartik\widgets\Select2;
use kartik\widgets\ActiveForm;

use yii\widgets\Pjax;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\LockersSearch $searchModel
 */

$this->title = 'Laporan Anggota Sering Meminjam';
$this->params['breadcrumbs'][] = $this->title;


$month = array();
$year = range(date('Y') , date('Y') - 10);
$y=array();

for ($m=1; $m<=12; $m++) 
{
     $month[$m] = date('F', mktime(0,0,0,$m, 1, date('Y')));
     // echo $month. '<br>';
}

foreach ($year as $year => $value) {
    $y[$value] = $value;
}
//print_r($y);

$kriteria = ['' => 'Semua Kriteria',
        'range_umur' => 'Kelompok Umur',
        'jenis_kelamin' => 'Jenis Kelamin',
        'jenis_anggota' => 'Jenis Anggota',
        'Pekerjaan' => 'Pekerjaan',
        'Pendidikan' => 'Pendidikan',
        'unit_kerja' => 'Unit Kerja',
        'jenis_identitas' => 'Jenis Identitas',
        'propinsi' => 'Provinsi Sesuai Identitas',
        'kabupaten' => 'Kabupaten/Kota Sesuai Identitas',
        'propinsi2' => 'Provinsi Tempat Tinggal',
        'kabupaten2' => 'Kabupaten/Kota Tempat Tinggal',
        'nama_institusi' => 'Nama Institusi'
        ];
?>

<style type="text/css">
    .gap-padding10{
        padding-bottom: 10px;
    }
    .padding0{
        padding: 0;
    }

    .select2-container--krajee .select2-selection {
        font-size: 12px;
    }
</style>

<div class="lockers-index">
    
    <form id="form-SearchFilter" method="POST" action="show-pdf">    
        <div id="SearchFilter" class="col-sm-12">
            <div class="form-horizontal">
                <div class="box-body">

                    <!-- Pilih Periode -->
                    <div class="form-group">
                        <label for="pilihPeriode" class="col-sm-2 control-label"><?= Yii::t('app','Periode')//.' '.Yii::t('app','Pengadaan') ?></label>

                        <div class="col-sm-10 row">
                            <div class="col-sm-4 padding0">
                                <?= Select2::widget([
                                'name' => 'periode',
                                'data' => ['harian' => 'Harian','bulanan' => 'Bulanan','tahunan' => 'Tahunan'],
                                'options' => [
                                // 'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Periode'),
                                'id' => 'pilihPeriode',
                                'class' => 'select2'
                                ],
                                ]); ?>
                            </div>
                            
                            <!-- Harian -->
                            <div class="col-sm-8" id="periodeHarian"  >
                                <?=  DatePicker::widget([
                                    'name' => 'from_date', 
                                    'type' => DatePicker::TYPE_RANGE,
                                    'value' => date('d-m-Y'),
                                    'name2' => 'to_date', 
                                    'value2' => date('d-m-Y'),
                                    'separator' => 's/d',
                                    'options' => ['placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Date')],
                                    'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',
                                    'todayHighlight' => true,
                                    'autoclose'=>true,
                                    'id' => 'rangeHarian',
                                    ]
                                    ]);
                                    ?>
                            </div><!-- /Harian -->
                            <!-- Bulanan -->
                            <div class="col-sm-8" id="periodeBulanan" hidden="hidden">
                                <div class="input-group"> 
                                    <div class="container-fluid padding0 col-sm-5">
                                        <div class="col-sm-6 padding0">
                                            <?= Select2::widget([
                                                'name' => 'fromBulan',
                                                'value' => date('m'),
                                                'data' => $month,
                                                'options' => [
                                                // 'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Month'),
                                                'id' => 'fromBulan',
                                                'class' => 'padding0'
                                                ],
                                                ]); ?>
                                        </div>
                                        <div class="col-sm-6 padding0">
                                            <?= Select2::widget([
                                                'name' => 'fromTahun',
                                                'data' => $y,
                                                'value' => date('Y'),
                                                'options' => [
                                                // 'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Year'),
                                                'id' => 'fromTahun',
                                                'class' => 'padding0'
                                                ],
                                                ]); ?>
                                        </div>
                                    </div>
                                    
                                    <center class="col-sm-1" id="basic-addon1" style="padding-top: 10px"> s/d </center> 

                                    <div class="container-fluid padding0 col-sm-5">
                                        <div class="col-sm-6 padding0">
                                            <?= Select2::widget([
                                                'name' => 'toBulan',
                                                'data' => $month,
                                                'value' => date('m'),
                                                'options' => [
                                                // 'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Month'),
                                                'id' => 'toBulan',
                                                'class' => 'padding0'
                                                ],
                                                ]); ?>
                                        </div>
                                        <div class="col-sm-6 padding0" >
                                            <?= Select2::widget([
                                                'name' => 'toTahun',
                                                'data' => $y,
                                                'value' => date('Y'),
                                                'options' => [
                                                // 'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Year'),
                                                'id' => 'toTahun',
                                                'class' => 'padding0'
                                                ],
                                                ]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /Bulanan -->
                            <!-- Tahunan -->
                            <div class="col-sm-8" id="periodeTahunan" hidden="hidden" >
                                <div class="input-group"> 
                                    <div class="">
                                        <?= Select2::widget([
                                            'name' => 'fromTahunan',
                                            'value' => date('Y'),
                                            'data' => $y,
                                            'options' => [
                                            // 'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Year'),
                                            'id' => 'fromTahunan',
                                            'class' => 'padding0'
                                            ],
                                            ]); ?>
                                    </div>
                                    
                                    <center class="input-group-addon" id="basic-addon1"> s/d </center> 

                                    <div class="">
                                        <?= Select2::widget([
                                            'name' => 'toTahunan',
                                            'value' => date('Y'),
                                            'data' => $y,
                                            'options' => [
                                            // 'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Year'),
                                            'id' => 'toTahunan',
                                            'class' => 'padding0'
                                            ],
                                            ]); ?>
                                    </div>
                                </div>
                            </div><!-- /Tahunan -->

                        </div>

                    </div>
                    <!-- /Pilih Periode -->

                    <!-- Pilih Kriteria -->
                    <div class="form-group">
                        <label for="kop" class="col-sm-2 control-label"><?= Yii::t('app','Jumlah Ranking') ?> </label>

                        <div class="col-sm-10 row">
                            <div class="checkbox">
                                <label>
                                    <input type="number" class="form-control col-sm-4" name="rank" style="margin-left: -20px; margin-top:-5px;" oninput="if(value.length>3)value=value.slice(0,3)" value="10" min="1">
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- /Pilih Kriteria -->

                    <!-- Pilih Kriteria -->
                    <div class="form-group multi-field-wrapper" id="pilihan-Kriteria">
                        <label for="pilihKriteria" class="col-sm-2 control-label"><?= Yii::t('app','Kriteria') ?> </label>

                        <!-- Group all Content and append here-->
                        <div class="col-sm-10 container-fluid padding0 multi-fields" id="appendContentHere">
                            
                            <!-- Group plus minus dan pilih kriteria -->
                            <div class="row col-sm-12 gap-padding10 multi-field">
                                <div class="col-sm-4 padding0">
                                    <div class="input-group">

                                        <div class="input-group-btn">
                                            <!-- <button type="button" class="btn btn-danger remove-field"><span class="glyphicon glyphicon-minus-sign"></span></button> -->
                                            <button type="button" class="btn btn-success add-field"><span class="glyphicon glyphicon-plus-sign"></span></button>
                                        </div>

                                        <div class="input-group">
                                            <?= Select2::widget([
                                                'name' => 'kriterias[]',
                                                'data'=> $kriteria,
                                                'options' => [
                                                'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Kriteria'),
                                                'class' => 'pilihKriteria',
                                                // 'id' => 'pilihKriteria'
                                                ],
                                                ]); ?>
                                        </div>
                                    </div>
                                </div>

                                <div id="" class="col-sm-8 content-kriteria" >

                                </div>
                            </div>
                            <!-- /Group plus minus dan pilih kriteria -->
                            
                        </div><!-- /Group all Content and append here-->

                    </div>
                    <!-- /Pilih Kriteria -->                    

                    <div class="form-group" style="margin-top: -20px;">
                        <label for="kriteria-pengunjung" name="kriteria-pengunjung" class="col-sm-2 control-label"><?= Yii::t('app','Kriteria Pengunjung') ?> </label>

                        <div class="col-sm-10 row">
                            <div class="checkbox">
                                <label style="margin-right: 50px;"><input type="checkbox" Name="anggota" value="anggota"> Belum dikembalikan </label>
                                <label style="margin-right: 50px;"><input type="checkbox" Name="non_anggota" value="non_anggota"> Sudah dikembalikan</label>
                                <label style="margin-right: 50px;"><input type="checkbox" Name="rombongan" value="rombongan"> Belum melewati tanggal jatuh tempo</label>
                                <label style="margin-right: 50px;"><input type="checkbox" Name="rombongan" value="rombongan"> Sudah melewati tanggal jatuh tempo</label>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="kop" class="col-sm-2 control-label"><?= Yii::t('app','Kop') ?> </label>

                        <div class="col-sm-10 row">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  Name="kop"> Ya / Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="form-group padding0">
                    <div class="col-sm-10 col-sm-offset-2 padding0">
                        <button id="tampilkan_frekuensi" type="button" class="btn btn-sm btn-primary"><?= Yii::t('app','Tampilkan') ?> <?= Yii::t('app','Frekuensi') ?></button>
                        <button id="tampilkan_data" type="button" class="btn btn-sm btn-primary"><?= Yii::t('app','Tampilkan') ?> <?= Yii::t('app','Detail') ?> <?= Yii::t('app','Data') ?></button>
                        <div class="btn-group" style="cursor:pointer;">
                           <button type="button" id="export" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 4px 12px !important; display: none;">
                                Export   <span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu">
                             <li><a id="export-excel-anggota-sering-meminjam-frekuensi">Excel-frekuensi</a></li>
                             <li><a id="export-excel-odt-anggota-sering-meminjam-frekuensi">Open-Office-Excel-frekuensi</a></li>
                             <li><a id="export-excel-anggota-sering-meminjam-data">Excel-data</a></li>
                             <li><a id="export-excel-odt-anggota-sering-meminjam-data">Open-Office-Excel-data</a></li>
                             <li><a id="export-word-anggota-sering-meminjam-frekuensi">Word-frekuensi</a></li>
                             <li><a id="export-odt-anggota-sering-meminjam-frekuensi">Open-Office-Word-frekuensi</a></li>
                             <li><a id="export-word-anggota-sering-meminjam-data">Word-data</a></li>
                             <li><a id="export-odt-anggota-sering-meminjam-data">Open-Office-Word-data</a></li>
                             <li><a id="export-pdf-anggota-sering-meminjam-frekuensi">PDF-Frekuensi</a></li>
                             <li><a id="export-pdf-anggota-sering-meminjam-data">PDF-data</a></li>
                           </ul>
                        </div>
                        <button id="reset" type="button" class="btn btn-sm btn-warning"><?= Yii::t('app','Reset') ?> <?= Yii::t('app','Kriteria') ?> </button>
                    </div>
                   
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </form> 


    <div hidden="hidden" class="col-sm-4 padding0">
        <?= Select2::widget([
            'name' => '',
            'data' => [],
            'options' => [],
            ]); ?>
    </div>

    <hr class="col-sm-12">
    <div id="show-pdf-content" class="col-sm-12">
        <!-- Nanti show PDF Disini -->
    </div>

</div>


<script type="text/javascript">
    
</script>



<?php
$this->registerJs("

    $.fn.select2.defaults.set('theme', 'krajee');

    $.get('load-filter-kriteria',{kriteria : 'tujuan'},function(data){
    
       $( '.content-tujuan' ).html( data ); 
       $('.content-tujuan').find('.select2').select2({
        // allowClear: true,
        }); 
    });

    // Filter Periode
    $('#pilihPeriode').change(function(){
        var periode = $(this).val();
        // alert(periode);
        if (periode == 'harian') 
        {
            $('#periodeHarian').show();
            $('#periodeBulanan').hide();
            $('#periodeTahunan').hide();
           
        } 
        else if (periode == 'bulanan') 
        {
            $('#periodeHarian').hide();
            $('#periodeBulanan').show();
            $('#periodeTahunan').hide();
        }
        else 
        {
            $('#periodeHarian').hide();
            $('#periodeBulanan').hide();
            $('#periodeTahunan').show();
        }
    });

    var i = 1;
    $('.add-field').click(function(e) {    
        $.get('load-selecter-anggota-sering-meminjam',{ i : i },function(data){
            $('.multi-fields').append(data);        
            // $('.multi-fields').find('.select2').select2();
            i++;
        });
    });
  

    // Pilih Kriteria per Row
    $('#pilihan-Kriteria').on('change','.pilihKriteria',function(){ 
        $( '.content-kriteria' ).html('<div style=\"padding-top: 10px;\">Loading...</div>'); 
        var kriteria = $(this).val();
        console.log(kriteria);
     
        $.get('load-filter-kriteria',{kriteria : kriteria},function(data){
            if (data == '') 
            {
                $( '.content-kriteria' ).html( '' );   
            } 
            else 
            {
               $( '.content-kriteria' ).html( data ); 
               $('.content-kriteria').find('.select2').select2({
                // allowClear: true,
                }); 
               $('.content-kriteria').find('#w0').kvDatepicker();
               $('.content-kriteria').find('#w0-2').kvDatepicker();
            }
        });

    });



    // Tampilkan Frekuensi
    var form = $('#form-SearchFilter');
    $('#tampilkan_frekuensi').click(function(){
        $.ajax({
            type:\"POST\",
            url:'show-pdf?tampilkan=anggota-sering-meminjam-frekuensi',
            data:form.serialize(),
            success: function(response){
                console.log(response);  
                $( '#show-pdf-content' ).html( response ); 
                $('#export-excel-anggota-sering-meminjam-frekuensi').show();
                $('#export-excel-odt-anggota-sering-meminjam-frekuensi').show();
                $('#export-word-anggota-sering-meminjam-frekuensi').show();
                $('#export-odt-anggota-sering-meminjam-frekuensi').show();
                $('#export-pdf-anggota-sering-meminjam-frekuensi').show();
                $('#export-excel-anggota-sering-meminjam-data').hide();
                $('#export-excel-odt-anggota-sering-meminjam-data').hide();
                $('#export-word-anggota-sering-meminjam-data').hide();
                $('#export-odt-anggota-sering-meminjam-data').hide();
                $('#export-pdf-anggota-sering-meminjam-data').hide();
            }
        });
    });
    $('#tampilkan_data').click(function(){
        $.ajax({
            type:\"POST\",
            url:'show-pdf?tampilkan=anggota-sering-meminjam-data',
            data:form.serialize(),
            success: function(response){
                console.log(response);  
                $( '#show-pdf-content' ).html( response ); 
                $('#export-excel-anggota-sering-meminjam-frekuensi').hide();
                $('#export-excel-odt-anggota-sering-meminjam-frekuensi').hide();
                $('#export-word-anggota-sering-meminjam-frekuensi').hide();
                $('#export-odt-anggota-sering-meminjam-frekuensi').hide();
                $('#export-pdf-anggota-sering-meminjam-frekuensi').hide();
                $('#export-excel-anggota-sering-meminjam-data').show();
                $('#export-excel-odt-anggota-sering-meminjam-data').show();
                $('#export-word-anggota-sering-meminjam-data').show();
                $('#export-odt-anggota-sering-meminjam-data').show();
                $('#export-pdf-anggota-sering-meminjam-data').show();
            }
        });
    });
    $('#export-excel-anggota-sering-meminjam-frekuensi').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-excel-anggota-sering-meminjam-frekuensi',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-excel-anggota-sering-meminjam-frekuensi')
              }
            });
            
    });
    $('#export-excel-odt-anggota-sering-meminjam-frekuensi').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-excel-odt-anggota-sering-meminjam-frekuensi',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-excel-odt-anggota-sering-meminjam-frekuensi')
              }
            });
            
    });
    $('#export-excel-anggota-sering-meminjam-data').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-excel-anggota-sering-meminjam-data',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-excel-anggota-sering-meminjam-data')
              }
            });
            
    });
    $('#export-excel-odt-anggota-sering-meminjam-data').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-excel-odt-anggota-sering-meminjam-data',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-excel-odt-anggota-sering-meminjam-data')
              }
            });
            
    });
    $('#export-word-anggota-sering-meminjam-frekuensi').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-word-anggota-sering-meminjam-frekuensi',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-word-anggota-sering-meminjam-frekuensi?type=doc')
              }
            });
            
    });
    $('#export-odt-anggota-sering-meminjam-frekuensi').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-odt-anggota-sering-meminjam-frekuensi',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-word-anggota-sering-meminjam-frekuensi?type=odt')
              }
            });
            
    });
    $('#export-word-anggota-sering-meminjam-data').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-word-anggota-sering-meminjam-data',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-word-anggota-sering-meminjam-data?type=doc')
              }
            });
            
    });
    $('#export-odt-anggota-sering-meminjam-data').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-odt-anggota-sering-meminjam-data',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-word-anggota-sering-meminjam-data?type=odt')
              }
            });
            
    });
    $('#export-pdf-anggota-sering-meminjam-frekuensi').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-pdf-anggota-sering-meminjam-frekuensi',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-pdf-anggota-sering-meminjam-frekuensi')
              }
            });
            
    });
    $('#export-pdf-anggota-sering-meminjam-data').click(function(){
        $.ajax({
            type:\"POST\",
            url: 'show-pdf?tampilkan=export-pdf-anggota-sering-meminjam-data',
            data:form.serialize(),
            async: false,
              context: document.body,
              success: function(){ 
                 window.location.assign('export-pdf-anggota-sering-meminjam-data')
              }
            });
            
    });
    $('#reset').click(function(){
        location.reload();
    });

");
?>
