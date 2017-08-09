<?php 

// echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border: none; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Frekuensi <?= $LaporanPeriode ?> <br>Sering di Baca <?= $LaporanPeriode2 ?> <br>Berdasarkan Ranking <?= $inValue ?><br> 
			
			
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
							Frekuensi 
						</td>
						<td style="font-weight: bold;">
							Data Bibliografis 
						</td>
						<td style="font-weight: bold;">
							Jumlah Pembaca
						</td>
					</tr>

					<?php $i = 1; ?>
					<?php $totalFrekuensi = 0; ?>
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
								<?= $TableLaporan['Frekuensi'] ?>
							</td>
							<td>
								<?= $TableLaporan['data'], $TableLaporan['data2'], $TableLaporan['data3'], $TableLaporan['data4'], $TableLaporan['data5'], $TableLaporan['data6'], $TableLaporan['data7'] ?>
							</td>
							<td>
								<?= $TableLaporan['Jumlah'] ?>
							</td>
						</tr>
						<?php $totalFrekuensi = $totalFrekuensi + $TableLaporan['Frekuensi']  ?>
						<?php $totalJumlahExemplar = $totalJumlahExemplar + $TableLaporan['Jumlah']  ?>
						<?php $i++ ?>
					<?php endforeach ?>

					<tr>
						<td colspan="2" style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $totalFrekuensi  ?>
						</td>
						<td style="font-weight: bold;">
						
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahExemplar  ?>
						</td>
					</tr>

				</table>

<!--<?php print_r($TableLaporan); ?>-->

	</center>
</div>