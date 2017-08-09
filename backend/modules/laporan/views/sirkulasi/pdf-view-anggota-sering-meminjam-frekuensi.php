<?php

// echo $sql;
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detai Data <?= $LaporanPeriode ?><br> Anggota Sering Meminjam <?= $LaporanPeriode2 ?>  <br> Berdasarkan <?= $Berdasarkan ?>
			
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
							Frekuensi
						</td>
						<td style="font-weight: bold;">
						<?php //if (implode($_POST['kriterias']) == $kriterias && ($kriterias != 'data_entry') && (count($_POST['kriterias'])) == 1):?>
						<!-- <td style="font-weight: bold;"> -->
							Nomor Anggota
						<!-- </td> -->
						</td>
						<?php// endif ?>
						<td style="font-weight: bold;">
							Nama Anggota
						</td>
						<td style="font-weight: bold;">
							Jumlah Judul
						</td>
						<td style="font-weight: bold;">
							Jumlah Eksemplar
						</td>
					</tr>
					<?php $i = 1; ?>
					<?php $JumlahFrekuensi = 0; ?>
					<?php $totalJumlahJudul = 0; ?>
					<?php $JumlahEksemplar = 0; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['Frekuensi'] ?>
							</td>
							<td>
								<?= $TableLaporan['NoAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['NamaAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['JumlahJudul'] ?>
							</td>
							<td>
								<?= $TableLaporan['JumlahEksemplar'] ?>
							</td>
						</tr>
						<?php $JumlahFrekuensi = $JumlahFrekuensi + $TableLaporan['Frekuensi']  ?>
						<?php $totalJumlahJudul = $totalJumlahJudul + $TableLaporan['JumlahJudul']  ?>
						<?php $JumlahEksemplar = $JumlahEksemplar + $TableLaporan['JumlahEksemplar']  ?>
						<?php $i++ ?>
					<?php endforeach ?>
					<tr>
						<td colspan='0' style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $JumlahFrekuensi  ?>
						</td>
						<td style="font-weight: bold;">
							
						</td>
						<td style="font-weight: bold;">
							
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahJudul  ?>
						</td>
						<td style="font-weight: bold;">
							<?= $JumlahEksemplar  ?>
						</td>
					</tr>

				</table>

<!-- <?php print_r($TableLaporan); ?> -->


	</center>
</div>