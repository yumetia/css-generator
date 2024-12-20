<?php
function my_rec_scandir($path){
	if (!is_dir($path)){
		echo "je peux pas bosser\n";
		return false;
	}
    $tab = [];
    if ($handle = opendir($path)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $fullpath = $path.DIRECTORY_SEPARATOR.$entry;
                if (is_dir($fullpath)) {
                    if(basename($fullpath)=="Sprite"){
                        continue;
                    }
                    $tab = array_merge($tab,my_rec_scandir($fullpath));                  
                }
                elseif (preg_match('/\.png$/',$entry)||preg_match('/\.jpg$/',$entry)){
					$tab[]=$fullpath;
				}
            }  
        }      
        closedir($handle);
    }
    return $tab;
}

?>
