<?php 
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
?>
	
	
	<?php 
	$no=0;
	$item=0;
	$rec=0;
	$jumlahData=count($LabelData);
	foreach ($LabelData as $LabelData): 
	$rec++; 

	if($item == 0){
		echo '<div style="padding:58px;">';
		echo '<table cellspacing="0" cellpadding="0">';
	}

	if($no==0)
	{
		echo '<tr>';
	}

	?>

	<td style="width:50%;padding-bottom: 25px; padding-right: 55px; text-align: left;">
		<table style="width:283px; " cellpadding="0" cellspacing="0">
			<tr>
			<?php ($LabelData['Warna1'] == '') ? $warna='' : $warna=';background-color:'.$LabelData['Warna1']; ?>
				<td style="border:solid 1px #000; height:53px; width:212px; text-align: center; "><?=$LabelData['NamaPerpustakaan']?></td>
				<td style="width:25%;border-top:solid 1px #000;border-bottom:solid 1px #000; border-right:solid 1px #000;text-align: center <?=$warna?>" rowspan="2"><?=str_replace(' ', '<br>', $LabelData['CallNumber'])?></td>
			</tr>
			<tr>
				<td style="height:90px; width:75%; text-align: center;padding-left: 3px; padding-right: 3px;border-left:solid 1px #000; border-bottom:solid 1px #000; border-right:solid 1px #000;">
					<span style="font-size: 12px"><?=$LabelData['Title']?>
					<br>
					<?php 
					echo '<img style="padding-top:5px;width:212px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($LabelData['Barcode'], $generator::TYPE_CODE_39,1)) . '">';
					?>
					<br>
					*<?=$LabelData['Barcode']?>*
					</span>
				</td>
			</tr>
		</table>
	</td>

	<?php

	if($no == 1 || $i == ($jumlahData -1))
    {
       if($i == ($jumlahData -1))
       {
            echo '<td style="width:50%;padding-bottom:25px; padding-right: 55px; text-align: left;">&nbsp;</td>';
       }
       echo '</tr>';
       $no=0;
    }else{
       $no++;
    }

	if($item == 11 || $rec == $jumlahData)
    {
       echo '</table>';
       echo '</div>';
       $item=0;
    }else{
       $item++;
    }

	?>
	

	<?php
	endforeach 
	?>
					