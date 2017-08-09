<?php

//echo $sql;
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Data <?= $LaporanPeriode ?><br> Pemanfaatan OPAC <?= $LaporanPeriode2 ?>  <br> Berdasarkan <?= $Berdasarkan ?>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							<?php //if ($kriterias == 'data_entry'){ echo "Periode"; }
							//else{ echo "Periode Pendaftaran";} ?>
							Tanggal Akses
						</td>
						<td style="font-weight: bold;">
							IP Address
						</td>
						<td style="font-weight: bold;">
							Jenis Pencarian
						</td>
						<td style="font-weight: bold;">
							Ruas Pencarian
						</td>
						<td style="font-weight: bold; width: 45%;">
							Kata Kunci
						</td>
					</tr>
					<?php $i = 1; ?>
					<?php $JumlahLoker = 0; ?>
					<?php $JumlahPeminjam = 0; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['TglAkses'] ?>
							</td>
							<td>
								<?= $TableLaporan['ip'] ?>
							</td>
							<td>
								<?= $TableLaporan['JenisPencarian'] ?>
							</td>
							<td>
								<?= $TableLaporan['RuasPencarian'] ?>
							</td>
							<td>
								<?= $TableLaporan['KataKunci'] ?>
							</td>
						</tr>
						<?php $i++ ?>
					<?php endforeach ?>
				</table>

<!-- <?php print_r($TableLaporan); ?> -->


	</center>
</div>