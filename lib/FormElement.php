<?php 
require("colorin.php");

function EasyName($LoPrimero="",$Lon=16){
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return $LoPrimero.'-'.substr(str_shuffle($permitted_chars), 0, $Lon).'';
}



function FormElement_input($Label, $Value="", $PlaceHolder = "", $SmallText = "", $type="", $IdElement="", $disable=FALSE, $Colorin = FALSE,  $Color="" ){
    //clases de Bootstrap
    $IdDiv = EasyName("Div");
    if ($IdElement == ''){
        $IdElement = EasyName("ie");
    }

    if ($type==""){
        $type="text";
    }

    if ($disable == TRUE){
        echo '
        <div class="form-group disable" id="'.$IdDiv.'" style="margin: 4px;
        padding: 4px;
        border-radius: 5px;
        vertical-align: top;">';

        echo '
            <label for="'.$IdElement.'" style="font-size:8pt; margin-bottom: 6pt;">'.$Label.'</label>
            <input title="'.$Value.'" style="cursor:pointer; font-size:9pt; margin-top:-7px;" type="'.$type.'" class="form-control" id="'.$IdElement.'" placeholder="'.$PlaceHolder.'" value="'.$Value.'" readonly>
            <small id="'.$IdElement.'_smalltext'.'" class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;">'.$SmallText.'</small>
        </div>';

    } else {
        
        if ($Colorin == FALSE){
            echo '<div class="form-group" id="'.$IdDiv.'" style="margin: 4px;padding: 4px;border-radius: 5px;vertical-align: top;">';
        } else {
            if ($Color == ""){    
                echo '<div class="form-group" id="'.$IdDiv.'" style="background-color:rgba('.Colorin_Rand("rgb").',0.5); margin: 4px;padding: 4px;border-radius: 5px;vertical-align: top;">';
            } else {
                
                echo '<div class="form-group" id="'.$IdDiv.'" style="background-color:rgba('.Colorin_search($Color, "rgb").',0.5); margin: 4px;padding: 4px;border-radius: 5px;vertical-align: top;">';
            }
          
        }
        // echo "COLOR=".$Color;

        echo '
            <label for="'.$IdElement.'" style="font-size:8pt;margin-bottom: 6pt;">'.$Label.'</label>
            <input title="'.$Value.'" style="font-size:9pt; margin-top:-7px;" type="'.$type.'" class="form-control" id="'.$IdElement.'" placeholder="'.$PlaceHolder.'" value="'.$Value.'">
            <small id="'.$IdElement.'_smalltext'.'" class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;">'.$SmallText.'</small>
        </div>';
    }

}




function FormElement_textarea($Label, $Value="", $PlaceHolder = "", $SmallText = "", $type="", $IdElement="", $disable=FALSE, $Colorin = FALSE,  $Color="" ){
    //clases de Bootstrap
    $IdDiv = EasyName("Div");
    if ($IdElement == ''){
        $IdElement = EasyName("ie");
    }

    if ($type==""){
        $type="text";
    }

    if ($disable == TRUE){
        echo '
        <div class="form-group disable" id="'.$IdDiv.'" style="margin: 4px;
        padding: 4px;
        border-radius: 5px;
        vertical-align: top;">';

        echo '
            <label for="'.$IdElement.'" style="font-size:8pt;">'.$Label.'</label>
            <textarea title="'.$Value.'" style="cursor:pointer; font-size:9pt; margin-top:-7px;" type="'.$type.'" class="form-control" id="'.$IdElement.'" placeholder="'.$PlaceHolder.'"  readonly>'.$Value.'</textarea>
            <small id="'.$IdElement.'_smalltext'.'" class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;">'.$SmallText.'</small>
        </div>';

    } else {
        if ($Colorin == FALSE){
       echo '<div class="form-group" id="'.$IdDiv.'" style="margin: 4px;padding: 4px;border-radius: 5px;vertical-align: top;">';
        } else {
            if ($Color == ""){    
                echo '<div class="form-group" id="'.$IdDiv.'" style="background-color:rgba('.Colorin_Rand("rgb").',0.5); margin: 4px;padding: 4px;border-radius: 5px;vertical-align: top;">';
            } else {
                
                echo '<div class="form-group" id="'.$IdDiv.'" style="background-color:rgba('.Colorin_search($Color, "rgb").',0.5); margin: 4px;padding: 4px;border-radius: 5px;vertical-align: top;">';
            }
        }

        echo '
            <label for="'.$IdElement.'" style="font-size:8pt;">'.$Label.'</label>
            <textarea title="'.$Value.'" style="font-size:9pt; margin-top:-7px;" type="'.$type.'" class="form-control" id="'.$IdElement.'" placeholder="'.$PlaceHolder.'">'.$Value.'</textarea>
            <small id="'.$IdElement.'_smalltext'.'" class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;">'.$SmallText.'</small>
        </div>';
    }

}

?>