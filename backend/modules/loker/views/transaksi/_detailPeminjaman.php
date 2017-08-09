<?php 

use common\models\MasterUangJaminan;
use common\models\MasterJenisIdentitas;

 ?>

<div id="section-to-print">
 	<!-- Table Detail Peminjaman -->
    <div class="table-responsive" id="pilihLocker" > <!-- hidden="hidden" -->
        <table class="table table-condensed table-bordered table-striped table-hover request-table" style="table-layout: fixed;">
            <tbody>
            	<tr>
            		<td class="col-sm-4">Nomor Peminjaman</td>
            		<td class="col-sm-8" id="noPeminjaman"><?php echo $model->No_pinjaman; ?></td>
            	</tr>
            	<tr>
            		<td>Nomor Member</td>
            		<td><?php echo $model->no_member; ?> </td>
            	</tr>

				<!-- Data Members atau Memberguesses -->
            	<tr>
            		<td>Nama</td>
            		<td><?php echo $data["nama"]; ?> </td>
            	</tr>
<!--             	<tr>
            		<td>Jenis Kelamin</td>
            		<td><?php echo $data["jenisKelamin"]; ?></td>
            	</tr>

 -->

                <?php if ($model->jenis_jaminan): ?>
            	<tr>
            		<td>Jenis Jaminan</td>
            		<td><?php echo $model->jenis_jaminan; ?></td>
            	</tr>
            	<tr>
	            	<?php if ($model->jenis_jaminan == 'Kartu Identitas') {
	            		$jenisIdentitas = MasterJenisIdentitas::findOne($model->id_jamin_idt);
	            		echo "<td>No. Identitas - ".$jenisIdentitas->Nama."</td>";
	            		echo '<td>'.$model->no_identitas.'</td>';
	            	} else if ($model->jenis_jaminan == 'Uang') {
	            		$uangJaminan = MasterUangJaminan::findOne($model->id_jamin_uang) ;
	            		echo "<td>Nominal Uang Jaminan</td>";
	            		echo '<td>'.$uangJaminan->No.' ( '.$uangJaminan->Name.' ) </td>';
	            	}
	            	?>
            	</tr>
                <?php endif ?>
            	
                <tr>
            		<td>Locker</td>
            		<td><?php echo $data["lockers"]; ?></td>
            	</tr>
            	<tr>
            		<td>Tanggal Peminjaman</td>
            		<td><?php echo $model->tanggal_pinjam; ?></td>
            	</tr>
            </tbody>
        </table>
    </div>



	<?php 
	// DetailView::widget([
 //            'model' => $model,
            
 //        'attributes' => [
 //            'No_pinjaman',
 //            'no_member',
 //            'no_identitas',
 //            'jenis_jaminan',
 //            'id_jamin_idt',
 //            'id_jamin_uang',
 //            'loker_id',
 //            'tanggal_pinjam',
 //            'tanggal_kembali',
 //        ],
 //    ]) 
    ?>
</div>