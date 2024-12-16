<?php 
include "spriteGen.php";

$options = getopt("ri:s:p:o:c:",["recursive","output-image:","output-style:","padding:","override-size:","columns_number:","help"]);

function displayChoice($path){
    global $options;
    
    echo "what path do u wanna work on ? (ex : '.' = current directory ) : ";
    $path = trim(fgets(STDIN));

    echo "\nWhat type of sprite ? (vertical/horizontal)\nType 'v' ou 'h' : ";
    $input = fgets(STDIN);
    
    while(true){

        if (trim($input)==="v"){
            $tabDim = spriteGenVer($path,$options);
            return [$tabDim,"v"];

        } elseif (trim($input)==="h"){
            $tabDim = spriteGenHor($path,$options);
            return [$tabDim,"h"];

        } else{
            echo "mmmhh, wrong command... \ntry again: ";
            $input = fgets(STDIN);
        }
    }
}


function cssGen($fileCss= "style.css")
{
    global $options;
    // help if necessary in the begining
    $help = showHelp();
    if ($help!==null){
        echo $help;
        return;
    } 

    if (isset($options['s'])||isset($options['output-style'])){
        $fileCss = $options['s']??$options['output-style'];
    }
    $tabDim = displayChoice($path="."); 
    
    // array[0] contains images ?? if not its not an array .Verifying..
    if (!is_array($tabDim[0])){
        echo $tabDim[0];
        return $tabDim[0];
    }
    $h = false;
    $v = false;
    if ($tabDim[1]==="v"){
        $cssContent = ".sprite-container {\n\tdisplay: inline-block;\n\tposition: relative;\n}\n";
        $v = true;
    }
    else {
        $cssContent = ".sprite-container {\n\tdisplay: flex;\n\tposition: relative;\n}\n";
        $h = true;
    }
    $xoffset = 0;
    for ($i=0; $i < count($tabDim[0]); $i+=3) {
        $imgPath = $tabDim[0][$i];
        $width = $tabDim[0][$i+1];
        $height = $tabDim[0][$i+2];
        // for windows users
        $imgPath = str_replace('\\','\\\\',$imgPath);

        $spriteName = ".sprite".$i/3+1;
        // applying the dimensions from the -o or override-size option if defined
        if ( isset($options['o']) || isset($options["override-size"] ) ){
            $cssContent .= "\n$spriteName {
\tbackground-image: url('$imgPath');
\twidth: ".($options['o']??$options["override-size"])."px".";
\theight: ".($options['o']??$options["override-size"])."px;"; 
        } else {
            $cssContent .= "\n$spriteName {
\tbackground-image: url('$imgPath');
\twidth: ".$width."px".";
\theight: ".$height."px;";	
        }
        
        if ( $h && $i/3+1>1 && (isset($options['p'])) || isset($options["padding"] ) ){
            $cssContent.="\n\tbackground-position:".$xoffset+($options['p']??$options["padding"])."px".", 0px;\n";
            $cssContent.="\tflex-shrink:"."0;"."\n";
            $cssContent.="\tmargin-left: ".($options['p']??$options["padding"])."px;"."\n}\n";
            
        }
        if( $v && $i/3+1>1 && (isset($options['p'])) || isset($options["padding"]) ){
            $cssContent.="\n\tbackground-position:".-$xoffset-($options['p']??$options["padding"])."px".", 0px;\n";
            $cssContent.="\tmargin-top:".($options['p']??$options["padding"])."px;"."\n}\n";
        }
        elseif(($i/3+1==1) && $v){    
            $cssContent.="\n\tbackground-position:".-$xoffset."px".", 0px;\n";
            $cssContent.="\n}\n";
        }
        elseif(($i/3+1==1) && $h){    
            $cssContent.="\n\tbackground-position:".$xoffset."px".", 0px;\n";
            $cssContent.="\n}\n";
        }
        else {
            if ( (!isset($options['o']) && !isset($options["override-size"])) && !$h ){
                $cssContent.="}\n";
            }
        }
		$xoffset += $width;
        file_put_contents($fileCss,$cssContent);
    }
    echo "\nSprite generated !\n";
    return $fileCss;
}
cssGen();

function showHelp(){
    global $options;
    if (isset($options["help"])&&count($options)===1){
        return file_get_contents("help.txt");
    }
    else{
        return null;
    }
}

?>
