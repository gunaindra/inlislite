<?php 

//echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";
// die;
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border: none; margin: 40; margin-top: 0px;">

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?> <br /> Pengadaan Koleksi <?= $LaporanPeriode2 ?> <br>Berdasarkan <?= $Berdasarkan ?><br>
			<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
				<tr class="success" >
					<td style="font-weight: bold;">
						No.
					</td>
					<td style="font-weight: bold;">
						Tanggal Pengusulan
					</td>
					<td style="font-weight: bold;">
						Judul
					</td>
					<td style="font-weight: bold;">
						Penerbitan
					</td>
					<td style="font-weight: bold;">
						Anggota Pengusul
					</td>
					<td style="font-weight: bold;">
						Status Usulan
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
							<?= $TableLaporan['TanggalPengusulan'] ?>
						</td>
						<td>
							<?= $TableLaporan['Judul'] ?>
						</td>
						<td>
							<?= $TableLaporan['Penerbitan'] ?>
						</td>
						<td>
							<?= $TableLaporan['Anggota'] ?>
						</td>
						<td>
							<?= $TableLaporan['StatusUsulan'] ?>
						</td>
						
					</tr>
				
					<?php $i++ ?>
				<?php endforeach ?>
			</table>
		</p>
	</center>

</div>