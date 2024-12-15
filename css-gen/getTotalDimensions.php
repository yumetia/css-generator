<?php 
include "my_rec_scandir.php";
include "my_scandir.php";
function getTotalWidth($path,$rec)
{
	// recursive call or not ? Verifying..
	if ($rec){
		$tab = my_rec_scandir($path);
	} else {
		$tab = my_scandir($path);
	}

	$maxHeight = 0;
	$totalWidth = 0;
	
	foreach ($tab as $element){
		
		if (substr($element,-3)==="jpg"){
			$img = @imagecreatefromjpeg($element);
		} elseif (substr($element,-3)==="png"){
			$img = @imagecreatefrompng($element);
		}

		if ($img!==false){
			if (imagesy($img) > $maxHeight){
				$maxHeight = imagesy($img);
			}
			$totalWidth += imagesx($img);
		}
	}
	return ["maxHeight"=>$maxHeight,"totalWidth" => $totalWidth ];
}




function getTotalHeight($path,$rec)
{
	// recursive call or not ? Verifying..
	if ($rec){
		$tab = my_rec_scandir($path);
	} else {
		$tab = my_scandir($path);
	}

	$totalHeight = 0;
	$maxWidth = 0;
	
	foreach ($tab as $element){
		if (substr($element,-3)==="jpg"){
			$img = @imagecreatefromjpeg($element);
		} elseif (substr($element,-3)==="png"){
			$img = @imagecreatefrompng($element);
		}
		if ($img!==false){
			if (imagesx($img) > $maxWidth){
				$maxWidth = imagesx($img);
			}
			$totalHeight += imagesy($img);
		} 

	}
	return ["maxWidth"=>$maxWidth,"totalHeight" => $totalHeight ];
}


?>
