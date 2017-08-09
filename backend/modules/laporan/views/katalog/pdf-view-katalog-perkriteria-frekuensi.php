<?php 

// echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";
$kriterias = implode($_POST['kriterias']);
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border: none; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Frekuensi <?= $LaporanPeriode ?><br> Katalog Perkriteria <?= $LaporanPeriode2 ?>  <br> Berdasarkan <?= $Berdasarkan ?> <br>
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
	<?php if ($kriterias == 'bahan_pustaka'): ?>
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal
						</td>
						<td style="font-weight: bold;">
							Bahan Pustaka 
						</td>
						<td style="font-weight: bold;">
							Jumlah 
						</td>
					</tr>

					<?php $i = 1; ?>
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
								<?= $TableLaporan['BahanPustaka'] ?>
							</td>
							<td>
								<?= $TableLaporan['Jumlah'] ?>
							</td>
						</tr>
						<?php $totalJumlahExemplar = $totalJumlahExemplar + $TableLaporan['Jumlah']  ?>
						<?php $i++ ?>
					<?php endforeach ?>

					<tr>
						<td colspan="3" style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahExemplar  ?>
						</td>
					</tr>

				</table>
	
	<?php elseif ($kriterias == 'kataloger'): ?>
				<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Periode
						</td>
						<td style="font-weight: bold;">
							Kataloger 
						</td>
						<td style="font-weight: bold;">
							Jumlah 
						</td>
					</tr>

					<?php $i = 1; ?>
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
								<?= $TableLaporan['Kataloger'] ?>
							</td>
							<td>
								<?= $TableLaporan['Jumlah'] ?>
							</td>
						</tr>
						<?php $totalJumlahExemplar = $totalJumlahExemplar + $TableLaporan['Jumlah']  ?>
						<?php $i++ ?>
					<?php endforeach ?>

					<tr>
						<td colspan="3" style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahExemplar  ?>
						</td>
					</tr>
				</table>

	<?php elseif ($kriterias == 'no_klas'): ?>
				<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal
						</td>
						<td style="font-weight: bold;">
							Kelas Besar 
						</td>
						<td style="font-weight: bold;">
							Jumlah Judul 
						</td>
						<td style="font-weight: bold;">
							Jumlah Eksemplar 
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
								<?= $TableLaporan['kelas'] ?>
							</td>
							<td>
								<?= $TableLaporan['CountJudul'] ?>
							</td>
							<td>
								<?= $TableLaporan['Jumlah'] ?>
							</td>
						</tr>
						<?php $totalJumlahJudul = $totalJumlahJudul + $TableLaporan['CountJudul']  ?>
						<?php $totalJumlahExemplar = $totalJumlahExemplar + $TableLaporan['Jumlah']  ?>
						<?php $i++ ?>
					<?php endforeach ?>

					<tr>
						<td colspan="3" style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahJudul  ?>
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahExemplar  ?>
						</td>
					</tr>
				</table>

	<?php elseif (($kriterias == 'subjek') || ($kriterias == 'judul') || ($kriterias == 'location')): ?>
				<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal
						</td>
						<td style="font-weight: bold;">
							<?= ($this->context->getRealNameKriteria($kriterias)); ?>
						</td>
						<td style="font-weight: bold;">
							Frekuensi 
						</td>
					</tr>

					<?php $i = 1; ?>
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
								<?= $TableLaporan['Kataloger'] ?>
							</td>
							<td>
								<?= $TableLaporan['Jumlah'] ?>
							</td>
						</tr>
						<?php $totalJumlahExemplar = $totalJumlahExemplar + $TableLaporan['Jumlah']  ?>
						<?php $i++ ?>
					<?php endforeach ?>

					<tr>
						<td colspan="3" style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahExemplar  ?>
						</td>
					</tr>

				</table>
			<?php endif ?>		
<!--<?php print_r($TableLaporan); ?>-->

	</center>
</div>