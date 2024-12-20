<?php
function my_scandir($path){
    if (!is_dir($path)){
        echo "je peux pas bosser\n";
        return false;
    }
    $tab = [];
    if ($handle = opendir($path)) {
        while (false!==($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $fullpath = $path.DIRECTORY_SEPARATOR.$entry;

                if(preg_match('/\.png$/',$entry)||preg_match('/\.jpg$/',$entry)){
                    $tab[]=$fullpath;
                }
            }  
        }      
        closedir($handle);
    }
    return $tab;
}

?>