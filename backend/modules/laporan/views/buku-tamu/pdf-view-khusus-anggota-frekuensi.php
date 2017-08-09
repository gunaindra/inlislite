<?php

// echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";

?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Frekuensi <?= $LaporanPeriode ?> <br>Khusus Anggota <?= $LaporanPeriode2 ?>  <br> Berdasarkan <?= $Berdasarkan ?> <br>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px;">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success">
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal Kunjungan
						</td>
						<td style="font-weight: bold;">
							Lokasi Perpustakaan
						</td>
						<td style="font-weight: bold;">
							Lokasi Ruang
						</td>
						<td style="font-weight: bold;">
							Jumlah Anggota
						</td>
					</tr>
					<?php $i = 1; ?>
					<?php $totalJumlahAnggota = 0; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['Periode'] ?>
							</td>
							<td>
								<?= $TableLaporan['Ruang'] ?>								
							</td>
							<td>
								<?= $TableLaporan['Nama_perpus'] ?>								
							</td>
							<td>
								<?= $TableLaporan['Jumlah'] ?>
							</td>
						</tr>
						<?php $totalJumlahAnggota = $totalJumlahAnggota + $TableLaporan['Jumlah']  ?>
						<?php $i++ ?>
					<?php endforeach ?>
					<tr>
						<td colspan="4" style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahAnggota  ?>
						</td>
					</tr>

				</table>

<!-- <?php print_r($TableLaporan); ?> -->


	</center>
</div>