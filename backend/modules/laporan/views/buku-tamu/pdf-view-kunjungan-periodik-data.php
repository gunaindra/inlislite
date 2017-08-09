<?php 

// echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";

?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?><br>Kunjungan Periodeik <?= $LaporanPeriode2 ?><br /> Berdasarkan <?= $Berdasarkan ?><br>			
		<!-- <?php print_r($TableLaporan); ?>-->

			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px;">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success">
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal Kujungan
						</td>
						<td style="font-weight: bold;">
							Lokasi Perpustakaan
						</td>
						<td style="font-weight: bold;">
							Lokasi Ruang
						</td>
						<td style="font-weight: bold;">
							Nomor Kunjungan
						</td>
						<td style="font-weight: bold;">
							Nama
						</td>
						<td style="font-weight: bold;">
							Jenis Kelamin
						</td>
						<td style="font-weight: bold;">
							Pekerjaan
						</td>
						<td style="font-weight: bold;">
							Pendidikan
						</td>
						<td style="font-weight: bold;">
							Tujuan Kunjungan
						</td>
						<td style="font-weight: bold;">
							Informasi Dicari
						</td>
					</tr>

					<?php $i = 1; ?>
					<?php $totalJumlahJudul = 0; ?>
					<?php $totalJumlahExemplar = 0; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['periode'] ?>
							</td>
							<td>
								<?= $TableLaporan['lokasi'] ?>
							</td>
							<td>
								<?= $TableLaporan['lok_ruang'] ?>
							</td>
							<td>
								<?= $TableLaporan['no_pengunjung'] ?>
							</td>
							<td>
								<?= $TableLaporan['nama'] ?>
							</td>
							<td>
								<?= $TableLaporan['gender'] ?>
							</td>
							<td>
								<?= $TableLaporan['pekerjaan'] ?>
							</td>
							<td>
								<?= $TableLaporan['pendidikan'] ?>
							</td>
							<td>
								<?= $TableLaporan['tujuan'] ?>
							</td>
							<td>
								<?= $TableLaporan['info'] ?>
							</td>
						</tr>
						<?php $i++ ?>
					<?php endforeach ?>

		</table>
	</center>
</div>