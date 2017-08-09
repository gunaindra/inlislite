<?php 

// echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";

?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?><br /> Pengadaan Koleksi <?= $LaporanPeriode2 ?> <br>Berdasarkan <?= $Berdasarkan ?>
			<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
				<tr class="success" >
					<td style="font-weight: bold;">
						No.
					</td>
					<td style="font-weight: bold;">
						Nomor Induk
					</td>
					<td style="font-weight: bold;">
						Data Bibliografis
					</td>
					<td style="font-weight: bold;">
						Nomor Panggil
					</td>
					<td style="font-weight: bold;">
						Tanggal Pengadaan
					</td>
					<td style="font-weight: bold;">
						Sumber Perolehan
					</td>
					<td style="font-weight: bold;">
						Jenis Bahan
					</td>
					<td style="font-weight: bold;">
						Bentuk Fisik
					</td>
					<td style="font-weight: bold;">
						Kategori
					</td>
					<td style="font-weight: bold;">
						Jenis Akses
					</td>
					<td style="font-weight: bold;">
						Harga
					</td>
					<td style="font-weight: bold;">
						Nomor Barcode
					</td>
					<td style="font-weight: bold;">
						Nomor RFID
					</td>
				</tr>

				<?php $i = 1; ?>
				<?php foreach ($TableLaporan as $TableLaporan): ?>
					<tr>
						<td>
							<?= $i ?>
						</td>
						<td>
							<?= $TableLaporan['NoInduk'] ?>
						</td>
						<td>
							<?= $TableLaporan['data'], $TableLaporan['data2'], $TableLaporan['data3'], $TableLaporan['data4'], $TableLaporan['data5'], $TableLaporan['data6'], $TableLaporan['data7'] ?>
						</td>
						<td>
							<?= $TableLaporan['NomorPanggil'] ?>
						</td>
						<td>
							<?= $TableLaporan['TanggalPengadaan'] ?>
						</td>
						<td>
							<?= $TableLaporan['SumberPerolehan'] ?>
						</td>
						<td>
							<?= $TableLaporan['JenisBahan'] ?>
						</td>
						<td>
							<?= $TableLaporan['JenisMedia'] ?>
						</td>
						<td>
							<?= $TableLaporan['Kategori'] ?>
						</td>
						<td>
							<?= $TableLaporan['JenisAkses'] ?>
						</td>
						<td>
							<?= $TableLaporan['Harga'] ?>
						</td>
						<td>
							<?= $TableLaporan['NomorBarcode'] ?>
						</td>
						<td>
							<?= $TableLaporan['RFID'] ?>
						</td>
					</tr>
				
					<?php $i++ ?>
				<?php endforeach ?>

				

			</table>



			<?php //print_r($TableLaporan) ?>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	







	</center>
</div>