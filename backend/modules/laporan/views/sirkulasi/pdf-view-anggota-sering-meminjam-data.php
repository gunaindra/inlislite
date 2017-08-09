<?php

//echo $sql;
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Frekuensi <?= $LaporanPeriode ?><br> Anggota Terdaftar <?= $LaporanPeriode2 ?>  <br> Berdasarkan <?= $Berdasarkan ?>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							<?php //if ($kriterias == 'data_entry'){ echo "Periode"; }
							//else{ echo "Periode Pendaftaran";} ?>
							Tanggal Pinjam
						</td>
						<td style="font-weight: bold;">
						<?php //if (implode($_POST['kriterias']) == $kriterias && ($kriterias != 'data_entry') && (count($_POST['kriterias'])) == 1):?>
						<!-- <td style="font-weight: bold;"> -->
							Nomor Induk
						<!-- </td> -->
						</td>
						<?php// endif ?>
						<td style="font-weight: bold;">
							Data Bibliografis
						</td>
						<td style="font-weight: bold;">
							Nomor Anggota
						</td>
						<td style="font-weight: bold;">
							Nama Anggota
						</td>
						<td style="font-weight: bold;">
							Jenis Kelamin
						</td>
						<td style="font-weight: bold;">
							Tempat, Tanggal Lahir
						</td>
						<td style="font-weight: bold;">
							Umur
						</td>
						<td style="font-weight: bold;">
							Alamat
						</td>
						<td style="font-weight: bold;">
							Kabupaten / Kota
						</td>
						<td style="font-weight: bold;">
							Propinsi
						</td>
						<td style="font-weight: bold;">
							Telpon
						</td>
						<td style="font-weight: bold;">
							Email
						</td>
						<td style="font-weight: bold;">
							Jenis Anggota
						</td>
						<td style="font-weight: bold;">
							Pekerjaan
						</td>
						<td style="font-weight: bold;">
							Pendidikan
						</td>
					</tr>
					<?php $i = 1; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['TglPinjam'] ?>
							</td>
							<td>
								<?= $TableLaporan['no_induk'] ?>
							</td>
							<td>
								<?= $TableLaporan['DataBib'] ?>
							</td>
							<td>
								<?= $TableLaporan['NoAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['NamaAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['Gender'] ?>
							</td>
							<td>
								<?= $TableLaporan['TempatTanggalLahir'] ?>
							</td>
							<td>
								<?= $TableLaporan['Umur'] ?>
							</td>
							<td>
								<?= $TableLaporan['Alamat'] ?>
							</td>
							<td>
								<?= $TableLaporan['Kabupaten'] ?>
							</td>
							<td>
								<?= $TableLaporan['Propinsi'] ?>
							</td>
							<td>
								<?= $TableLaporan['Telp'] ?>
							</td>
							<td>
								<?= $TableLaporan['email'] ?>
							</td>
							<td>
								<?= $TableLaporan['jenis_anggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['pekerjaan'] ?>
							</td>
							<td>
								<?= $TableLaporan['Pendidikan'] ?>
							</td>
						</tr>
						<?php $i++ ?>
					<?php endforeach ?>

				</table>

<!-- <?php print_r($TableLaporan); ?> -->


	</center>
</div>