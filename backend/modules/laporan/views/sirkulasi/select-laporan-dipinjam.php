<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use kartik\widgets\Select2;


// Pilihan Filter Kriteria
$ckriteria = [
        '' =>  Yii::t("app","Choose")." ".Yii::t("app","Kriteria"),
        'PublishLocation' => 'Kota Terbit',
        'Publisher' => 'Nama Penerbit',
        'PublishYear' => 'Tahun Terbit',
        'location_library' => 'Lokasi Perpustakaan',
        'locations' => 'Ruang Perpustakaan',
        'collectionsources' => 'Jenis Sumber Perolehan',
        'partners' => 'Nama Sumber/Rekanan Perolehan',
        'currency' => 'Mata Uang',
        'harga' => 'Harga',
        'collectioncategorys' => 'Kategori',
        'collectionrules' => 'Jenis Akses',
        'worksheets' => 'Jenis Bahan',
        'collectionmedias' => 'Bentuk Fisik',
        'Subject' => 'Subjek',
        'no_klas' => 'No. Klas',
        'no_panggil' => 'No. Panggil'
        ];
?>
<!-- Group plus minus dan pilih kriteria -->
<div class="row col-sm-12 gap-padding10 multi-field">
    <div class="col-sm-4 padding0">
        <div class="input-group">

            <div class="input-group-btn">
                <button type="button" class="btn btn-danger remove-field"><span class="glyphicon glyphicon-minus-sign"></span></button>
                <!-- <button type="button" class="btn btn-success add2"><span class="glyphicon glyphicon-plus-sign"></span></button> -->
            </div>

            <div class="input-group">
                <?= Html::dropDownList( 'kriterias[]',
                    'selected option',  
                    $ckriteria, 
                    ['class' => 'col-sm-12 select2 pilihKriteriaDipinjam'.$i,'placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Kriteria')]
                    ); ?>
            </div>
        </div>
    </div>

    <div id="" class="col-sm-8 content-kriteria-dipinjam<?= $i ?>" >

    </div>
</div>
<!-- /Group plus minus dan pilih kriteria -->

<script type="text/javascript">
    $('.pilihKriteriaDipinjam<?= $i ?>').select2();
    $('.remove-field').click(function(e) {
        $(this).parent('.input-group-btn').parent('.input-group').parent('.col-sm-4').parent('.multi-field').remove();
        //klo tinggal satu ga bisa di apus
        // if($('.multi-field').length > 1) {
            // $(this).parent('.input-group-btn').parent('.input-group').parent('.col-sm-4').parent('.multi-field').remove();
        // }
    });

        // Pilih Kriteria per Row
    $('#pilihan-Kriteria-dipinjam').on('change','.pilihKriteriaDipinjam<?= $i ?>',function(){ 
        $( '.content-kriteria<?= $i ?> ' ).html('<div style=\"padding-top: 10px;\">Loading...</div>'); 
        var kriteria = $(this).val();
        console.log(kriteria);
     
        $.get('load-filter-kriteria-dipinjam',{kriteria : kriteria},function(data){
            if (data == '') 
            {
                $( '.content-kriteria-dipinjam<?= $i ?>' ).html( '' );   
            } 
            else 
            {
                $( '.content-kriteria-dipinjam<?= $i ?>' ).html( data ); 
                $('.content-kriteria-dipinjam<?= $i ?>').find('.select2').select2({
                // allowClear: true,
                });
               // $('.content-kriteria<?= $i ?>').find('.krajee-datepicker').datepicker();
               // $('.content-kriteria<?= $i ?>').find('.krajee-datepicker').datepicker("show");

            }
        });
    });
</script>