<?php 

//echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";
//$kriterias = implode($_POST['kriterias']);
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?><br /> Pengembalian Terlambat <?= $LaporanPeriode2 ?> <br />Berdasarkan Anggota <?= $test?>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
<table width="100%" class="table table-bordered" style="text-align: center; font-size: 11px; font-family: times new roman; border: 1px solid black;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal
						</td>
						<td style="font-weight: bold;">
							Anggota
						</td>
						<td style="font-weight: bold;">
							Nomor Barcode
						</td>
						<td style="font-weight: bold;">
							Tanggal Pinjam
						</td>
						<td style="font-weight: bold;">
							Tanggal Jatuh Tempo
						</td>
						<td style="font-weight: bold;">
							Tanggal Kembali
						</td>
						<td style="font-weight: bold;">
							Hari Terlambat
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
								<?= $TableLaporan['Periode'] ?>
							</td>
							<td>
								<?= $TableLaporan['Anggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['no_barcode'] ?>
							</td>
							<td>
								<?= $TableLaporan['tgl_pinjam'] ?>
							</td>
							<td>
								<?= $TableLaporan['tgl_tempo'] ?>
							</td>
							<td>
								<?= $TableLaporan['tgl_pengembalian'] ?>
							</td>
							<td>
								<?= $TableLaporan['terlambat'] ?>
							</td>
						</tr>
						<?php $i++ ?>
					<?php endforeach ?>

		</table>
	</center>
</div>