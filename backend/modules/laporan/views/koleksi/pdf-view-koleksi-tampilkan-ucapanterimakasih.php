<?php 

 // echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";

?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<table border="0" style=" font-size: 12px;font-family: times new roman;">
			<tr>
				<td width="100px">Nomor </td>
				<td>:</td>
			</tr>
			<tr>
				<td>Perihal </td>
				<td>: Ucapan Terima Kasih </td>
			</tr>
		</table>
	</center>
	<p style="font-size: 12px; margin-top: 20px">
		Dengan Hormat, <br>

		Melalui surat ini kami informasikan bahwa sumbangan koleksi berupa :
	</p>

		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
				<tr class="success">
					<td style="font-weight: bold; text-align: center">
						No.
					</td>
					<td style="font-weight: bold; text-align: center">
						Judul
					</td>
					<td style="font-weight: bold; text-align: center">
						Pengarang
					</td>
					<td style="font-weight: bold; text-align: center">
						Penerbitan
					</td>
					
				</tr>


				<?php $i = 1; ?>
				<?php foreach ($TableLaporan as $TableLaporan): ?>
					<tr>
						<td style="text-align: center">
							<?= $i ?>
						</td>
						<td>
							<?= $TableLaporan['Judul'] ?>
						</td>
						<td>
							<?= $TableLaporan['pengarang'] ?>
						</td>
						<td>
							<?= $TableLaporan['penerbit'] ?>
						</td>
					</tr>
				
					<?php $i++ ?>
				<?php endforeach ?>

			</table>

	<p style="font-size: 12px; margin-top: 20px">
		Telah kami terima dalam keadaan baik. Sumbangan tersebut sangat bermanfaat bagi kami.<br>

		Atas partisipasi dan perhatiannya kami ucapkan terima kasih.
		<br/>
		<br/>
		<br/>
		<b>Jakarta, <?= $LaporanPeriode ?><b>
	</p>
</div>
