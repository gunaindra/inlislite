<?php 

// echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";
$kriterias = implode($_POST['kriterias']);
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin: 40px; margin-top: 0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Data <?= $LaporanPeriode ?>  <br>Katalog Perkriteria <?= $LaporanPeriode2 ?><br />Berdasarkan <?= $Berdasarkan ?>
		<!-- <?php print_r($TableLaporan); ?>-->
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
		<?php if ($kriterias == 'kataloger'): ?>
				<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
							<tr class="success" >
								<td style="font-weight: bold; width: 50px;">
									No.
								</td>
								<td style="font-weight: bold;">
									Nomer Panggil
								</td>
								<td style="font-weight: bold;">
									BIB ID
								</td>
								<td style="font-weight: bold;">
									Pengarang
								</td>
								<td style="font-weight: bold;">
									Judul
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
									Subjek
								</td>
								<td style="font-weight: bold;">
									Username
								</td>
								<td style="font-weight: bold;">
									Tanggal Dibuat
								</td>
							</tr>

							<?php $i = 1; ?>
							<?php foreach ($TableLaporan as $TableLaporan): ?>
								<tr>
									<td>
										<?= $i ?>
									</td>
									<?php if ($kriterias != 'subjek'
									):?>
									<td>
										<?= $TableLaporan['NoPanggil'] ?>
									</td>
									<?php endif ?>
									<td>
										<?= $TableLaporan['BIBID'] ?>
									</td>
									<td>
										<?= $TableLaporan['Pengarang'] ?>
									</td>
									<td>
										<?= $TableLaporan['Judul'] ?>
									</td>
									<td>
										<?= $TableLaporan['Penerbitan'] ?>
									</td>
									<td>
										<?= $TableLaporan['PUBLISHYEAR'] ?>
									</td>
									<td>
										<?= $TableLaporan['Deskripsifisik'] ?>
									</td>
									<td>
										<?= $TableLaporan['subjek'] ?>
									</td>
									<td>
										<?= $TableLaporan['UserName'] ?>
									</td>
									<td>
										<?= $TableLaporan['CreateDate'] ?>
									</td>
								</tr>
								<?php $i++ ?>
							<?php endforeach ?>
				</table>

		<?php elseif ($kriterias == 'subjek' || $kriterias == 'judul' || $kriterias == 'no_klas'): ?>
			<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
							<tr class="success" >
								<td style="font-weight: bold; width: 50px;">
									No.
								</td>
								<td style="font-weight: bold;">
									Tanggal
								</td>
								<?php if($kriterias != 'judul'):?>
								<td style="font-weight: bold;">
									<?php if ($kriterias != 'no_klas'){echo "Subjek";}else{echo "Kelas Besar";} ?>
								</td>
								<?php endif ?>
								<td style="font-weight: bold;">
									Control Number
								</td>
								<td style="font-weight: bold;">
									BIB-ID
								</td>
								<td style="font-weight: bold;">
									Judul
								</td>
								<td style="font-weight: bold;">
									Pengarang 
								</td>
								<td style="font-weight: bold;">
									Penerbit
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
									<?php if($kriterias != 'judul'):?>
									<td>
										<?= $TableLaporan['Judul'] ?>
									</td>
									<?php endif ?>
									<td>
										<?= $TableLaporan['NoPanggil'] ?>
									</td>
									<td>
										<?= $TableLaporan['BIBID'] ?>
									</td>
									<td>
										<?= $TableLaporan['Judul'] ?>
									</td>
									<td>
										<?= $TableLaporan['Pengarang'] ?>
									</td>
									<td>
										<?= $TableLaporan['publisher'] ?>
									</td>
								</tr>
								<?php $i++ ?>
							<?php endforeach ?>
				</table>
			<?php endif ?>

	</center>
</div>