<?php 

// echo $sql;
// die;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";
$kriterias = implode($_POST['kriterias']);
$test = ($this->context->getRealNameKriteria($kriterias));
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >
	
	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">		
			Laporan Frekuensi <?= $LaporanPeriode ?> <br> Pengadaan Koleksi <?= $LaporanPeriode2 ?> <br/>Berdasarkan <?= $Berdasarkan ?>
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
						<?php if (sizeof($_POST['kriterias']) !=1) {
						}else
						{ echo '<td style="font-weight: bold; width: 120px;">'.$test.' </td>'; }?>
						<td style="font-weight: bold;">
							Jumlah Judul
						</td>
						<td style="font-weight: bold; width: 90px; ">
							Jumlah Eksemplar
						</td>
					</tr>
					<?php $i = 1; ?>
					<?php $totalJumlahEksemplar = 0; ?>
					<?php $totalJumlahJudul = 0; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['Periode'] ?>
							</td>
							<?php if (sizeof($_POST['kriterias']) !=1) {
							}else
							{ echo '<td style="width: 120px;">'.$TableLaporan['Subjek'].' </td>'; }?>
							<td>
								<?= $TableLaporan['JumlahJudul'] ?>
							</td>
							<td>
								<?= $TableLaporan['CountEksemplar'] ?>
							</td>
						</tr>
						<?php $totalJumlahEksemplar = $totalJumlahEksemplar + $TableLaporan['CountEksemplar']  ?>
						<?php $totalJumlahJudul = $totalJumlahJudul + $TableLaporan['JumlahJudul']  ?>
						<?php $i++ ?>
					<?php endforeach ?>
					<tr>
						<td <?php if (sizeof($_POST['kriterias']) !=1){echo 'colspan="2"';} else {echo 'colspan="3"';}?> style="font-weight: bold;">
							Total
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahJudul  ?>
						</td>
						<td style="font-weight: bold;">
							<?= $totalJumlahEksemplar  ?>
						</td>
					</tr>

				</table>

<!-- <?php print_r($TableLaporan); ?> -->


	</center>
</div>