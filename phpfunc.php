<?php 
function mdy($mid = "month", $did = "day", $yid = "year", $mval, $dval, $yval)
    {
        if(empty($mval)) $mval = date("m");
        if(empty($dval)) $dval = date("d");
        if(empty($yval)) $yval = date("Y");

        $months = array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
        $out = "<select name='$mid' id='$mid'>";
        foreach($months as $val => $text)
            if($val == $mval) $out .= "<option value='$val' selected>$text</option>";
            else $out .= "<option value='$val'>$text</option>";
        $out .= "</select> ";

        $out .= "<select name='$did' id='$did'>";
        for($i = 1; $i <= 31; $i++)
            if($i == $dval) $out .= "<option value='$i' selected>$i</option>";
            else $out .= "<option value='$i'>$i</option>";
        $out .= "</select> ";

        $out .= "<select name='$yid' id='$yid'>";
        for($i = date("Y"); $i >= date("Y") -5; $i--)
            if($i == $yval) $out.= "<option value='$i' selected>$i</option>";
            else $out.= "<option value='$i'>$i</option>";
        $out .= "</select>";

        return $out;
    }
 ?>