<?php 
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
?>

	<?php foreach ($LabelData as $LabelData): ?>
		<table style="width: 100%;" cellpadding="0" cellspacing="0">
			<tr>
				<td style="border:solid 1px #00; height:47px; text-align: center; padding: 5px " colspan="2"><?=$LabelData['NamaPerpustakaan']?></td>
			</tr>
			<tr>
				<td style="height:82px; width:75%; text-align: center; padding-left: 3px; padding-right: 3px; border-left:solid 1px #000; border-bottom:solid 1px #000; border-right:solid 1px #000; float: left">
					<span style="font-size: 12px"><?=$LabelData['Title']?>
					<br>
					<?php 
					echo '<img style="padding-top:5px;width:74%" src="data:image/png;base64,' . base64_encode($generator->getBarcode($LabelData['Barcode'], $generator::TYPE_CODE_39,1)) . '">';
					?>
					<br>
					*<?=$LabelData['Barcode']?>*
					</span>
				</td>
				<td style="width:25%;border-bottom:solid 1px #000; border-right:solid 1px #000;text-align: center"><?=str_replace(' ', '<br>', $LabelData['CallNumber'])?></td>
			</tr>
		</table>
	<?php endforeach ?>
					