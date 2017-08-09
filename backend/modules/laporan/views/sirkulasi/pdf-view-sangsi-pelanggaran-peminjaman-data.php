<?php 

// echo $sql;
// echo "<pre>";
// var_dump($TableLaporan);
// echo "</pre>";
$kriterias = implode($_POST['kriterias']);
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?> <br /> Sangsi Pelanggaran Peminjaman <?= $LaporanPeriode2 ?> <br /> Berdasarkan <?= $Berdasarkan ?><br>						
		</p>
	</center>

	<center style="text-align: center; font-size: 11px">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success" >
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							Tanggal Pinjam
						</td>
						<td style="font-weight: bold;">
							Tanggal Jatuh Tempo
						</td>
						<td style="font-weight: bold;">
							Tanggal Dikembalikan
						</td>
						<td style="font-weight: bold;">
							Jumlah Hari Telat
						</td>
						<td style="font-weight: bold;">
							Jenis Pelanggaran
						</td>
						<td style="font-weight: bold;">
							Denda Uang
						</td>
						<td style="font-weight: bold;">
							Skorsing
						</td>
						<td style="font-weight: bold;">
							Nomor Anggota
						</td>
						<td style="font-weight: bold;">
							Nama Anggota
						</td>
						<td style="font-weight: bold;">
							Data Bibliografis
						</td>
						<td style="font-weight: bold;">
							Nomor Induk 
						</td>
						<td style="font-weight: bold;">
							Petugas Peminjaman
						</td>
						<td style="font-weight: bold;">
							Petugas Pengembalian
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
								<?= $TableLaporan['TglPinjam'] ?>
							</td>
							<td>
								<?= $TableLaporan['TglJatuhTempo'] ?>
							</td>
							<td>
								<?= $TableLaporan['TglDikembalikan'] ?>
							</td>
							<td>
								<?= $TableLaporan['JumlahHariTelat'] ?>
							</td>
							<td>
								<?= $TableLaporan['jenis_pelanggaran'] ?>
							</td>
							<td>
								<?= $TableLaporan['DendaUang'] ?>
							</td>
							<td>
								<?= $TableLaporan['Skorsing'] ?>
							</td>
							<td>
								<?= $TableLaporan['NoAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['NamaAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['DataBib'] ?>
							</td>
							<td>
								<?= $TableLaporan['no_induk'] ?>
							</td>
							<td>
								<?= $TableLaporan['PetugasPeminjaman'] ?>
							</td>
							<td>
								<?= $TableLaporan['PetugasPengembalian'] ?>
							</td>
						</tr>
						<?php $i++ ?>
					<?php endforeach ?>

		</table>
	</center>
</div>