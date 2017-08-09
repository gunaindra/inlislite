<?php

// echo $sql;
$kriterias = implode($_POST['kriterias']);
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Frekuensi <?= $LaporanPeriode ?><br> Sirkulasi Peminjaman <?= $LaporanPeriode2 ?>  <br> Berdasarkan <?= $Berdasarkan ?>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal
						</td>
						<td style="font-weight: bold;">
							Jumlah Judul
						</td>
						<td style="font-weight: bold;">
							Jumlah Eksemplar
						</td>
						<td style="font-weight: bold;">
							Jumlah Peminjaman
						</td>
					</tr>
					<?php $i = 1; ?>
					<?php $totalJumlahJudul = 0; ?>
					<?php $JumlahEksemplar = 0; ?>
					<?php $JumlahPeminjam = 0; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['Periode'] ?>
							</td>
							<td>
								<?= $TableLaporan['JumlahJudul'] ?>
							</td>
							<td>
								<?= $TableLaporan['JumlahEksemplar'] ?>
							</td>
							<td>
								<?= $TableLaporan['JumlahPeminjam'] ?>
							</td>
						</tr>
						<?php $totalJumlahJudul = $totalJumlahJudul + $TableLaporan['JumlahJudul']  ?>
						<?php $JumlahEksemplar = $JumlahEksemplar + $TableLaporan['JumlahEksemplar']  ?>
						<?php $JumlahPeminjam = $JumlahPeminjam + $TableLaporan['JumlahPeminjam']  ?>
						<?php $i++ ?>
					<?php endforeach ?>
					<tr>
						<td colspan='2' style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahJudul  ?>
						</td>
						<td style="font-weight: bold;">
							<?= $JumlahEksemplar  ?>
						</td>
						<td style="font-weight: bold;">
							<?= $JumlahPeminjam  ?>
						</td>
					</tr>

				</table>

<!-- <?php print_r($TableLaporan); ?> -->


	</center>
</div>