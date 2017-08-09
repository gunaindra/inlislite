<?php 

// echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";

?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border: none; margin: 40; margin-top: 0px;">

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?> <br /> Buku Induk Perpustakaan <?= $LaporanPeriode2 ?><br>Berdasarkan <?= $Berdasarkan ?><br>
						
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
				<tr class="success" >
					<td style="font-weight: bold;">
						No.
					</td>
					<td style="font-weight: bold;">
						Tanggal Pengadaan
					</td>
					<td style="font-weight: bold;">
						Nomor Induk
					</td>
					<td style="font-weight: bold;">
						Jenis Bahan
					</td>
					<td style="font-weight: bold;">
						Bentuk Fisik
					</td>
					<td style="font-weight: bold;">
						Judul
					</td>
					<td style="font-weight: bold;">
						Pengarang
					</td>
					<td style="font-weight: bold;">
						Edisi
					</td>
					<td style="font-weight: bold;">
						Tempat Terbit
					</td>
					<td style="font-weight: bold;">
						Penerbit
					</td>
					<td style="font-weight: bold;">
						Tahun Terbit
					</td>
					<td style="font-weight: bold;">
						Deskripsi Fisik
					</td>
					<td style="font-weight: bold;">
						Jenis Sumber Perolehan
					</td>
					<td style="font-weight: bold;">
						Nama Sumber Perolehan
					</td>
					<td style="font-weight: bold;">
						Kategori
					</td>
					<td style="font-weight: bold;">
						ISBN
					</td>
					<td style="font-weight: bold;">
						ISSN
					</td>
					<td style="font-weight: bold;">
						Harga
					</td>
				</tr>


				<?php $i = 1; ?>
				<?php foreach ($TableLaporan as $TableLaporan): ?>
					<tr>
						<td>
							<?= $i ?>
						</td>
						<td>
							<?= $TableLaporan['TanggalPengadaan'] ?>
						</td>
						<td>
							<?= $TableLaporan['NoInduk'] ?>
						</td>
						<td>
							<?= $TableLaporan['JenisBahan'] ?>
						</td>
						<td>
							<?= $TableLaporan['BentukFisik'] ?>
						</td>
						<td>
							<?= $TableLaporan['Judul'] ?>
						</td>
						<td>
							<?= $TableLaporan['Pengarang'] ?>
						</td>
						<td>
							<?= $TableLaporan['Edisi'] ?>
						</td>
						<td>
							<?= $TableLaporan['TempatTerbit'] ?>
						</td>
						<td>
							<?= $TableLaporan['Penerbit'] ?>
						</td>
						<td>
							<?= $TableLaporan['TahunTerbit'] ?>
						</td>
						<td>
							<?= $TableLaporan['deskripsi'] ?>
						</td>
						<td>
							<?= $TableLaporan['JenisSumber'] ?>
						</td>
						<td>
							<?= $TableLaporan['Partner'] ?>
						</td>
						<td>
							<?= $TableLaporan['Kategori'] ?>
						</td>
						<td>
							<?= $TableLaporan['isbn'] ?>
						</td>
						<td>
							<?= $TableLaporan['issn'] ?>
						</td>
						<td>
							<?= $TableLaporan['Currency'] ?> - 
							<?= $TableLaporan['Price'] ?>
						</td>
						
					</tr>
				
					<?php $i++ ?>
				<?php endforeach ?>

			</table>
	</center>
</div>