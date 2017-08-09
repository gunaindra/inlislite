<?php 

// echo $sql;
// die;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border: none; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?> <br /> Koleksi Baca di Tempat <?= $LaporanPeriode2 ?><br> Berdasarkan <?= $Berdasarkan ?>
			
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px;">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success">
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal Baca
						</td>
						<td style="font-weight: bold;">
							Lokasi Perpustakaan
						</td>
						<td style="font-weight: bold;">
							Lokasi Ruang
						</td>
						<td style="font-weight: bold;">
							Nomor Induk 
						</td>
						<td style="font-weight: bold;">
							Data Bibliografis 
						</td>
						<td style="font-weight: bold;">
							Nomor Tamu / Anggota
						</td>
						<td style="font-weight: bold;">
							Nama 
						</td>
					</tr>

					<?php $i = 1; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['tgl_baca'] ?>
							</td>
							<td>
								<?= $TableLaporan['LokasiPerpustakaan'] ?>
							</td>
							<td>
								<?= $TableLaporan['LokasiRuang'] ?>
							</td>
							<td>
								<?= $TableLaporan['NoInduk'] ?>
							</td>
							<td>
								<?= $TableLaporan['DataBib'] ?>
							</td>
							<td>
								<?= $TableLaporan['NoAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['Nama'] ?>
							</td>
						</tr>
						<?php $i++ ?>
					<?php endforeach ?>

				</table>

<!--<?php print_r($TableLaporan); ?>-->

	</center>
</div>