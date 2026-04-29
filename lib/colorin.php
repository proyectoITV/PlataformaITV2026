<?php 

function Colorin_search($ColorName, $modo="hex"){
$file='lib/colorin.json';
    if (file_exists($file)) {
        $data = file_get_contents($file);    
        $Colores = json_decode($data, true);


            //140 elementos
            $NResul = 0;
            $NColores = Colorin_searchCount($ColorName);
            $NColorSelect = rand(1, $NColores);
            foreach ($Colores as $Color) { 
                // var_dump($Color);
                
                $Found = strpos($Color['ColorName'], $ColorName);
                if ($Found === FALSE) {

                } else {
                    $NResul = $NResul + 1;
                    
                    if ($NResul == $NColorSelect){

                        if ($modo == "hex"){
                           return $Color['hex'];                  
                        } else {
                            return $Color['rgb'];
                        }
                    }
                }

                // echo $Color['IdColor']."<br>";
                // echo $Color['ColorName']."<br>";
                // echo $Color['WebName']."<br>";
                // echo $Color['hex']."<br>";
                // echo $Color['rgb']."<hr>";

            }

    } else {
        echo "No existe colorines.json";
    }
}


function Colorin_Rand($modo="hex"){
$file='lib/colorin.json';
    if (file_exists($file)) {
        $data = file_get_contents($file);    
        $Colores = json_decode($data, true);


            //140 elementos
            $IdColor = rand(1, 140);
            foreach ($Colores as $Color) { 
                // var_dump($Color);

                if ($Color['IdColor'] == $IdColor){
                     if ($modo == "hex"){
                           return $Color['hex'];                  
                        } else {
                            return $Color['rgb'];
                        }
                }
                // echo $Color['IdColor']."<br>";
                // echo $Color['ColorName']."<br>";
                // echo $Color['WebName']."<br>";
                // echo $Color['hex']."<br>";
                // echo $Color['rgb']."<hr>";

            }

    } else {
        echo "No existe colorines.json";
    }
}




function Colorin_searchCount($ColorName){
$NResul = 0;
$file='lib/colorin.json';
    if (file_exists($file)) {
        $data = file_get_contents($file);    
        $Colores = json_decode($data, true);


            //140 elementos
            $NResul = 0;
            foreach ($Colores as $Color) { 
                // var_dump($Color);

                $Found = strpos($Color['ColorName'], $ColorName);
                if ($Found === FALSE) {

                } else {
                    $NResul = $NResul + 1;
                    

                   
                }

                // echo $Color['IdColor']."<br>";
                // echo $Color['ColorName']."<br>";
                // echo $Color['WebName']."<br>";
                // echo $Color['hex']."<br>";
                // echo $Color['rgb']."<hr>";

            }

            return $NResul;
    } else {
        return 0;
    }
    unset($NResul);
}
?>