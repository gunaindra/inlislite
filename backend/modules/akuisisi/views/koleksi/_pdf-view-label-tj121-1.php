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
		echo '<div style="padding-top:26px; padding-left:29px; padding-bottom:48px;padding-right:19px; ">';
		echo '<table cellspacing="0" cellpadding="0">';
	}

	if($no==0)
	{
		echo '<tr>';
	}

	?>

	<td style="width:50%;padding-bottom: 10px; padding-right: 10px; text-align: left;">
		<table style="width:283px; " cellpadding="0" cellspacing="0">
			<tr>
				<td style="border:solid 1px #000; height:53px; width:283px; text-align: center; " colspan="2"><?=$LabelData['NamaPerpustakaan']?></td>
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
				<td style="width:25%;border-bottom:solid 1px #000; border-right:solid 1px #000; text-align: center "><?=str_replace(' ', '<br>', $LabelData['CallNumber'])?></td>
			</tr>
		</table>
	</td>

	<?php

	if($no == 1 || $i == ($jumlahData -1))
    {
       if($i == ($jumlahData -1))
       {
            echo '<td style="width:50%;padding-bottom: 10px; padding-right: 10px; text-align: left;">&nbsp;</td>';
       }
       echo '</tr>';
       $no=0;
    }else{
       $no++;
    }

	if($item == 9 || $rec == $jumlahData)
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
					