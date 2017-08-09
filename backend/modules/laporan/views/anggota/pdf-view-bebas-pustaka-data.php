<?php 

//echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";

?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border: 0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?> <br /> Anggota Bebas Pustaka <?= $LaporanPeriode2 ?> <br> Berdasarkan <?= $Berdasarkan ?><br>
			<?php //print_r($TableLaporan) ?>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal Bebas Pustaka
						</td>
						<td style="font-weight: bold;">
							Nomor Anggota
						</td>
						<td style="font-weight: bold;">
							Anggota
						</td>
						<td style="font-weight: bold;">
							Jenis Kelamin
						</td>
						<td style="font-weight: bold;">
							Tempat & Tanggal Lahir
						</td>
						<td style="font-weight: bold;">
							Umur
						</td>
						<td style="font-weight: bold;">
							Alamat
						</td>
						<td style="font-weight: bold;">
							Kabupaten Kota
						</td>
						<td style="font-weight: bold;">
							Provinsi
						</td>
						<td style="font-weight: bold;">
							Telpon
						</td>
						<td style="font-weight: bold;">
							Email
						</td>
						<td style="font-weight: bold;">
							Pekerjaan
						</td>
						<td style="font-weight: bold;">
							Pendidikan
						</td>
						<td style="font-weight: bold;">
							Fakultas
						</td>
						<td style="font-weight: bold;">
							Jurusan
						</td>
						<td style="font-weight: bold;">
							Kelas
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
								<?= $TableLaporan['MemberNo'] ?>
							</td>
							<td>
								<?= $TableLaporan['Anggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['jenis_kelamin'] ?>
							</td>
							<td>
								<?= $TableLaporan['TTL'] ?>
							</td>
							<td>
								<?= $TableLaporan['umur'] ?>
							</td>
							<td>
								<?= $TableLaporan['alamat'] ?>
							</td>
							<td>
								<?= $TableLaporan['kab_kota'] ?>
							</td>
							<td>
								<?= $TableLaporan['provinsi'] ?>
							</td>
							<td>
								<?= $TableLaporan['telepon'] ?>
							</td>
							<td>
								<?= $TableLaporan['email'] ?>
							</td>
							<td>
								<?= $TableLaporan['pekerjaan'] ?>
							</td>
							<td>
								<?= $TableLaporan['pendidikan'] ?>
							</td>
							<td>
								<?= $TableLaporan['fakultas'] ?>
							</td>
							<td>
								<?= $TableLaporan['jurusan'] ?>
							</td>
							<td>
								<?= $TableLaporan['kelas'] ?>
							</td>
						</tr>
						<?php $i++ ?>
					<?php endforeach ?>
		</table>

<!-- <?php print_r($TableLaporan); ?> -->

	</center>
</div>