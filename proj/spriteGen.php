<?php
include "getTotalDimensions.php";

function spriteGenVer($path,$options,$spriteName="sprite.png",$padding=0){
	// padding
	if(isset($options["p"])||isset($options["padding"])){
		$padding = $options["p"] ?? $options["padding"];
	}

	if (isset($options['i']) || isset($options['output-image'])){
		$spriteName = $options['i'] ?? $options['output-image'] ;
	}
	if (isset($options['r']) || isset($options['recursive'])){
		$imgTabScan = my_rec_scandir($path);
		$tabDimMax = getTotalHeight($path,$rec=true); 
	} else {
		$imgTabScan = my_scandir($path);
		$tabDimMax = getTotalHeight($path,$rec=false); 
	}

	// checking if the -c or --columns_number is defined , 
	if (isset($options['c'])||isset($options["columns_number"])){
		$sumHeight = 0;
		$maxWidth = 0;
		$cptColumns = $options['c']??$options["columns_number"];
		$imgTabScan = array_slice($imgTabScan,0,$cptColumns);
		foreach($imgTabScan as $path){
			$imageDetails = @getimagesize($path);
			
			if ($imageDetails === false){
				echo "\nInaccess to the current file or invalid : $path\n";
				continue;
			}
			if ($imageDetails[0]>$maxWidth){
				$maxWidth = $imageDetails[0];
			}
			
			$sumHeight+=$imageDetails[1];
		}
		$widthS = $maxWidth;
		$heightS = $sumHeight;
		
	} 

	// verfying after the -c because imgTabScan may change..
	if (isset($options['o'])||isset($options["override-size"])){
		$widthS = $options['o']??$options["override-size"];
		
		$heightS = ($options['o']??$options["override-size"])*count($imgTabScan);
		// $heightS = $heightS *count($imgTabScan);

	}else {
		if (!isset($options['c'])&&!isset($options["columns_number"])){
			$widthS = $tabDimMax["maxWidth"];
			$heightS = $tabDimMax["totalHeight"] ;
		}
		// if theres no images in the current dir, return directly before creating a sprite
		if ($widthS==0){
			return "\nSorry, I cannot work..\nTheres no images in the current directory.\n";
		}
	}


	
	$paddingMax = $padding * count($imgTabScan) ;
	
	$sprite = imagecreatetruecolor($widthS,($heightS+$paddingMax)-$padding);
	// -$padding is useful to not add the padding to the last image in the sprite

	$currentY = 0;
	
	foreach ($imgTabScan as $path){
		$imageDetails = @getimagesize($path);

		if ($imageDetails === false){
			echo "\nInaccess to the current file or invalid : $path\n";
			continue;
		}
		if (isset($options['o'])||isset($options["override-size"])){
			$imgWidth = $options['o']??$options["override-size"] ;
			$imgHeight = $options['o']??$options["override-size"];	
		} else {
			$imgWidth = $imageDetails[0];
			$imgHeight = $imageDetails[1];
		}
	
		if (substr($path,-3)==="jpg"){
			$img = @imagecreatefromjpeg($path);
		}
		else {
			$img = @imagecreatefrompng($path);
		}
		if ($path==false){
			echo "\nCannot charge the current image : $path\n";
			continue;
		}
		
		imagecopy($sprite,$img,0,$currentY,0,0,$imgHeight,$imgHeight);
		$currentY+=$imgHeight+$padding;

		list($width,$height) = $imageDetails;
		$imgInfos[] = $path;
		$imgInfos[] = $width;
		$imgInfos[] = $height;

		
	}

	// need the folder Sprite 
    if (!is_dir("Sprite")){
        mkdir("Sprite");
    }

	imagepng($sprite,"Sprite".DIRECTORY_SEPARATOR.$spriteName);
	imagedestroy($sprite);
	

	return $imgInfos?? "\nno image detected !\n";
}





function spriteGenHor($path,$options,$spriteName="sprite.png",$padding=0){
	// padding 

	if(isset($options["p"])||isset($options["padding"])){
		$padding = $options["p"] ?? $options["padding"];
	}
	//
	if (isset($options['i']) || isset($options['output-image'])){
		$spriteName = $options['i'] ?? $options['output-image'] ;
	}

	if (isset($options['r']) || isset($options['recursive'])){
		$imgTabScan = my_rec_scandir($path);
		$tabDimMax = getTotalWidth($path,$rec=true); 
	} else {
		$imgTabScan = my_scandir($path);
		$tabDimMax = getTotalWidth($path,$rec=false); 
	}

	
	// checking if the -c or --columns_number is defined , 
	if (isset($options['c'])||isset($options["columns_number"])){
		$sumWidth = 0;
		$maxHeight = 0;
		$cptColumns = $options['c']??$options["columns_number"];
		$imgTabScan = array_slice($imgTabScan,0,$cptColumns);
		foreach($imgTabScan as $path){
			$imageDetails = @getimagesize($path);
			
			if ($imageDetails === false){
				echo "\nInaccess to the current file or invalid : $path\n";
				continue;
			}
			if ($imageDetails[1]>$maxHeight){
				$maxHeight = $imageDetails[1];
			}
			
			$sumWidth+=$imageDetails[0];
		}
		$widthS = $sumWidth;
		$heightS = $maxHeight;
		
	} 
	
	// verfying after the -c because imgTabScan may change...
	if (isset($options['o'])||isset($options["override-size"])){
		$widthS = ($options['o']??$options["override-size"])*count($imgTabScan);
		// $widthS = $widthS * count($imgTabScan);
		$heightS = $options['o']??$options["override-size"];
			
	}
	else {
		if (!isset($options['c'])&&!isset($options["columns_number"])){
			$widthS = $tabDimMax["totalWidth"];
			$heightS = $tabDimMax["maxHeight"] ;
		} 
		// if theres no images in the current dir, return directly before creating a sprite
		if ($widthS==0){
			return "\nSorry, I cannot work..\nTheres no images in the current directory.\n";
		}
	}

	$paddingMax = $padding * count($imgTabScan);
	
	$sprite = imagecreatetruecolor(($widthS+$paddingMax)-$padding,$heightS); 
	// -$padding is useful to not add the padding to the last image in the sprite
	
	$currentX = 0;
	
	foreach ($imgTabScan as $path){
		$imageDetails = @getimagesize($path);
		
		if ($imageDetails === false){
			echo "\nInaccess to the current file or invalid : $path\n";
			continue;
		}
		if (isset($options['o'])||isset($options["override-size"])){
			$imgWidth = $options['o']??$options["override-size"] ;
			$imgHeight = $options['o']??$options["override-size"];	
		} else {
			$imgWidth = $imageDetails[0];
			$imgHeight = $imageDetails[1];
		}
		
		if (substr($path,-3)==="jpg"){
			$img = @imagecreatefromjpeg($path);
		}
		else {
			$img = @imagecreatefrompng($path);
		}
		if ($path==false){
			echo "\nCannot charge the current image : $path\n";
			continue;
		}
		
		imagecopy($sprite,$img,$currentX ,0,0,0,$imgHeight,$imgHeight);

		$currentX+=$imgWidth +$padding;
		
		list($width,$height) = $imageDetails;
		$imgInfos[] = $path;
		$imgInfos[] = $width;
		$imgInfos[] = $height;

	
	}

	// need the folder Sprite 
    if (!is_dir("Sprite")){
        mkdir("Sprite");
    }

	imagepng($sprite,"Sprite".DIRECTORY_SEPARATOR.$spriteName);
	imagedestroy($sprite);
	
	return $imgInfos?? "\nno image detected !\n";
}


?>
