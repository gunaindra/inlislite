<?php

// echo $sql;
?>

<div class="panel panel-default panel-body" style="font-family: times new roman; border:0px; margin:40px; margin-top:0px;" >

	<center style="text-align: center; font-weight: bold;">
		<p style="text-align: center; font-size: 14px">
			Laporan Detail Data <?= $LaporanPeriode ?><br> Peminjaman Loker <?= $LaporanPeriode2 ?>  <br> Berdasarkan <?= $Berdasarkan ?>
			
		</p>
	</center>

	<center style="text-align: center; font-size: 11px;">	
		<table width="100%" border="1" class="table table-bordered" style="text-align: center; border-collapse: collapse; border: 1px solid black; font-size: 13px; font-family: times new roman;">
					<tr class="success">
						<td style="font-weight: bold;">
							No.
						</td>
						<td style="font-weight: bold;">
							<?php //if ($kriterias == 'data_entry'){ echo "Periode"; }
							//else{ echo "Periode Pendaftaran";} ?>
							Tanggal Pinjam
						</td>
						<td style="font-weight: bold;">
							Tanggal Dikembalikan
						</td>
						<td style="font-weight: bold;">
							Lokasi Perpustakaan
						</td>
						<td style="font-weight: bold;">
							Nomor Loker
						</td>
						<td style="font-weight: bold;">
							Nomor Anggota / Tamu
						</td>

						<td style="font-weight: bold;">
							Nama
						</td>
						<td style="font-weight: bold;">
							Jaminan
						</td>
						<td style="font-weight: bold;">
							Petugas Peminjaman
						</td>
						<td style="font-weight: bold;">
							Petugas Pengembalian
						</td>
					</tr>
					<?php $i = 1; ?>
					<?php $JumlahLoker = 0; ?>
					<?php $JumlahPeminjam = 0; ?>
					<?php foreach ($TableLaporan as $TableLaporan): ?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<td>
								<?= $TableLaporan['TglPinjam'] ?>
							</td>
							<td>
								<?= $TableLaporan['TglDikembalikan'] ?>
							</td>
							<td>
								<?= $TableLaporan['LokasiPerpustakaan'] ?>
							</td>
							<td>
								<?= $TableLaporan['NoLoker'] ?>
							</td>

							<td>
								<?= $TableLaporan['NoAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['NamaAnggota'] ?>
							</td>
							<td>
								<?= $TableLaporan['Jaminan'] ?>
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

<!-- <?php print_r($TableLaporan); ?> -->


	</center>
</div>