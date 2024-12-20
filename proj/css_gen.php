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

function generateBackground(){
    // function that returns the bodycss or null choosen by the user
    echo "\nDo u wanna set a background color for the body of the css file ?\n(yes or no ? y/n) ";
    $input = fgets(STDIN);
    while (true){
        if (trim($input)=="n"){
            echo "\nalright !";
            return null;
        }
        elseif(trim($input)=="y"){
            $css_colors = array(
                "AliceBlue" => "#F0F8FF",
                "AntiqueWhite" => "#FAEBD7",
                "Aqua" => "#00FFFF",
                "Aquamarine" => "#7FFFD4",
                "Azure" => "#F0FFFF",
                "Beige" => "#F5F5DC",
                "Bisque" => "#FFE4C4",
                "Black" => "#000000",
                "BlanchedAlmond" => "#FFEBCD",
                "Blue" => "#0000FF",
                "BlueViolet" => "#8A2BE2",
                "Brown" => "#A52A2A",
                "BurlyWood" => "#DEB887",
                "CadetBlue" => "#5F9EA0",
                "Chartreuse" => "#7FFF00",
                "Chocolate" => "#D2691E",
                "Coral" => "#FF7F50",
                "CornflowerBlue" => "#6495ED",
                "Cornsilk" => "#FFF8DC",
                "Crimson" => "#DC143C",
                "Cyan" => "#00FFFF",
                "DarkBlue" => "#00008B",
                "DarkCyan" => "#008B8B",
                "DarkGoldenRod" => "#B8860B",
                "DarkGray" => "#A9A9A9",
                "DarkGreen" => "#006400",
                "DarkKhaki" => "#BDB76B",
                "DarkMagenta" => "#8B008B",
                "DarkOliveGreen" => "#556B2F",
                "DarkOrange" => "#FF8C00",
                "DarkOrchid" => "#9932CC",
                "DarkRed" => "#8B0000",
                "DarkSalmon" => "#E9967A",
                "DarkSeaGreen" => "#8FBC8F",
                "DarkSlateBlue" => "#483D8B",
                "DarkSlateGray" => "#2F4F4F",
                "DarkTurquoise" => "#00CED1",
                "DarkViolet" => "#9400D3",
                "DeepPink" => "#FF1493",
                "DeepSkyBlue" => "#00BFFF",
                "DimGray" => "#696969",
                "DodgerBlue" => "#1E90FF",
                "FireBrick" => "#B22222",
                "FloralWhite" => "#FFFAF0",
                "ForestGreen" => "#228B22",
                "Fuchsia" => "#FF00FF",
                "Gainsboro" => "#DCDCDC",
                "GhostWhite" => "#F8F8FF",
                "Gold" => "#FFD700",
                "GoldenRod" => "#DAA520",
                "Gray" => "#808080",
                "Green" => "#008000",
                "GreenYellow" => "#ADFF2F",
                "HoneyDew" => "#F0FFF0",
                "HotPink" => "#FF69B4",
                "IndianRed" => "#CD5C5C",
                "Indigo" => "#4B0082",
                "Ivory" => "#FFFFF0",
                "Khaki" => "#F0E68C",
                "Lavender" => "#E6E6FA",
                "LavenderBlush" => "#FFF0F5",
                "LawnGreen" => "#7CFC00",
                "LemonChiffon" => "#FFFACD",
                "LightBlue" => "#ADD8E6",
                "LightCoral" => "#F08080",
                "LightCyan" => "#E0FFFF",
                "LightGoldenRodYellow" => "#FAFAD2",
                "LightGray" => "#D3D3D3",
                "LightGreen" => "#90EE90",
                "LightPink" => "#FFB6C1",
                "LightSalmon" => "#FFA07A",
                "LightSeaGreen" => "#20B2AA",
                "LightSkyBlue" => "#87CEFA",
                "LightSlateGray" => "#778899",
                "LightSteelBlue" => "#B0C4DE",
                "LightYellow" => "#FFFFE0",
                "Lime" => "#00FF00",
                "LimeGreen" => "#32CD32",
                "Linen" => "#FAF0E6",
                "Magenta" => "#FF00FF",
                "Maroon" => "#800000",
                "MediumAquaMarine" => "#66CDAA",
                "MediumBlue" => "#0000CD",
                "MediumOrchid" => "#BA55D3",
                "MediumPurple" => "#9370DB",
                "MediumSeaGreen" => "#3CB371",
                "MediumSlateBlue" => "#7B68EE",
                "MediumSpringGreen" => "#00FA9A",
                "MediumTurquoise" => "#48D1CC",
                "MediumVioletRed" => "#C71585",
                "MidnightBlue" => "#191970",
                "MintCream" => "#F5FFFA",
                "MistyRose" => "#FFE4E1",
                "Moccasin" => "#FFE4B5",
                "NavajoWhite" => "#FFDEAD",
                "Navy" => "#000080",
                "OldLace" => "#FDF5E6",
                "Olive" => "#808000",
                "OliveDrab" => "#6B8E23",
                "Orange" => "#FFA500",
                "OrangeRed" => "#FF4500",
                "Orchid" => "#DA70D6",
                "PaleGoldenRod" => "#EEE8AA",
                "PaleGreen" => "#98FB98",
                "PaleTurquoise" => "#AFEEEE",
                "PaleVioletRed" => "#DB7093",
                "PapayaWhip" => "#FFEFD5",
                "PeachPuff" => "#FFDAB9",
                "Peru" => "#CD853F",
                "Pink" => "#FFC0CB",
                "Plum" => "#DDA0DD",
                "PowderBlue" => "#B0E0E6",
                "Purple" => "#800080",
                "RebeccaPurple" => "#663399",
                "Red" => "#FF0000",
                "RosyBrown" => "#BC8F8F",
                "RoyalBlue" => "#4169E1",
                "SaddleBrown" => "#8B4513",
                "Salmon" => "#FA8072",
                "SandyBrown" => "#F4A460",
                "SeaGreen" => "#2E8B57",
                "SeaShell" => "#FFF5EE",
                "Sienna" => "#A0522D",
                "Silver" => "#C0C0C0",
                "SkyBlue" => "#87CEEB",
                "SlateBlue" => "#6A5ACD",
                "SlateGray" => "#708090",
                "Snow" => "#FFFAFA",
                "SpringGreen" => "#00FF7F",
                "SteelBlue" => "#4682B4",
                "Tan" => "#D2B48C",
                "Teal" => "#008080",
                "Thistle" => "#D8BFD8",
                "Tomato" => "#FF6347",
                "Turquoise" => "#40E0D0",
                "Violet" => "#EE82EE",
                "Wheat" => "#F5DEB3",
                "White" => "#FFFFFF",
                "WhiteSmoke" => "#F5F5F5",
                "Yellow" => "#FFFF00",
                "YellowGreen" => "#9ACD32"
            );
            // initializiation cssTab of 140 colors supported by all modern browsers

            echo "\nWrite ur color (name or hexa code ) : ";
            $inputY = fgets(STDIN);
            // ignoring case for the inputY to become detectable by the $css_colors arrays_keys 
            $inputY =  strtolower($inputY);
            $inputY =  ucfirst($inputY);

            if (in_array(trim($inputY),$css_colors)){
                $bodyCss = "body {\n\tbackground-color: ".trim($inputY).";\n}\n\n";
                return $bodyCss;
            }
            if (in_array(trim($inputY),array_keys($css_colors))){
                
                $bodyCss = "body {\n\tbackground-color: ".trim($inputY).";\n}\n\n";
                return $bodyCss;
            }
            else {
                echo "\ncolor not detected ! try again :\n ";
            }
            
        }
        else {
            echo "\nmmmhh, wrong command... \nRepeating, do u wanna set a background color for the body of the css file ?\n(yes or no ? y/n) ";
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
    
    // array[0] contains images ?? if not its not an array . Checking..
    if (!is_array($tabDim[0])){
        echo $tabDim[0];
        return $tabDim[0];
    }
    $cssContent = "";
    // body css choosen by the user ? if it is, adding it in the begining of the css file
    $bodyCss = generateBackground();
    if (!is_null($bodyCss)){
        $cssContent.=$bodyCss;
    }

    $h = false;
    $v = false;
    if ($tabDim[1]==="v"){
        $cssContent .= ".sprite-container {\n\tdisplay: inline-block;\n\tposition: relative;\n}\n";
        $v = true;
    }
    else {
        $cssContent .= ".sprite-container {\n\tdisplay: flex;\n\tposition: relative;\n}\n";
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
             
        if(( $i/3+1==1) && $v ){    
            $cssContent.="\n\tbackground-position:".-$xoffset."px".", 0px;\n";
            $cssContent.="}\n";
        }

        if( ($i/3+1==1) && $h ){    
            $cssContent.="\n\tbackground-position: ".$xoffset."px".", 0px;\n";
            $cssContent.="}\n";
        }

        if ( $h && $i/3+1>1  ) {
            $cssContent.="\n\tbackground-position: ".$xoffset."px".", 0px;\n";
            $cssContent.="\tflex-shrink: "."0;\n";
            if ((isset($options['p'])) || isset($options["padding"] )){
                $cssContent.="\tmargin-left: ".($options['p']??$options["padding"])."px;"."\n";
            }   
        }

        if( $v && $i/3+1>1  ){
            $cssContent.="\n\tbackground-position: ".-$xoffset."px".", 0px;\n";
            if ((isset($options['p'])) || isset($options["padding"])){
                $cssContent.="\tmargin-top: ".($options['p']??$options["padding"])."px;"."\n";
            }
        }

        if ( !($i/3+1==1) ){
            $cssContent.="}\n";
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
