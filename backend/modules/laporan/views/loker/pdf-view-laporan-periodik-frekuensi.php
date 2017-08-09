<?php

// echo $sql;
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Frekuensi <?= $LaporanPeriode ?><br> Peminjaman Loker <?= $LaporanPeriode2 ?>  <br> Berdasarkan <?= $Berdasarkan ?>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px;">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success">
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							<?php //if ($kriterias == 'data_entry'){ echo "Periode"; }
							//else{ echo "Periode Pendaftaran";} ?>
							Tanggal Pinjam
						</td>
						<td style="font-weight: bold;">
							Lokasi Perpustakaan
						</td>
						<td style="font-weight: bold;">
							Lokasi Ruangan
						</td>
						<td style="font-weight: bold;">
							Jumlah Loker
						</td>
						<td style="font-weight: bold;">
							Jumlah Peminjaman
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
								<?= $TableLaporan['PeriodePinjam'] ?>
							</td>
							<td>
								<?= $TableLaporan['LokasiPerpustakaan'] ?>
							</td>
							<td>
								<?= $TableLaporan['nama_ruang'] ?>
							</td>
							<td>
								<?= $TableLaporan['JumlahLoker'] ?>
							</td>
							<td>
								<?= $TableLaporan['JumlahPeminjam'] ?>
							</td>
						</tr>
						<?php $JumlahLoker = $JumlahLoker + $TableLaporan['JumlahLoker']  ?>
						<?php $JumlahPeminjam = $JumlahPeminjam + $TableLaporan['JumlahPeminjam']  ?>
						<?php $i++ ?>
					<?php endforeach ?>
					<tr>
						<td colspan='4' style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $JumlahLoker  ?>
						</td>
						<td style="font-weight: bold;">
							<?= $JumlahPeminjam  ?>
						</td>
					</tr>

				</table>

<!-- <?php print_r($TableLaporan); ?> -->


	</center>
</div>