<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dietSheetList
 *
 * @author admin
 */

class dietSheetList {
    
    public static function show($list) {
        $period = $_POST['period'];
        $i = 0;
        echo "<div class='blog'>";
        foreach ($list as $dietsheet) {
            echo "<div class='items-row cols-1 row-".$i." row-fluid clearfix'>";
            echo    "<div class='span12'>";
            echo        "<div class='item column-1'>";
            htmlhelper::dietSheetSimple($dietsheet, 1, $period);
            echo        "</div>";
            echo    "</div>";
            echo "</div>";
        }
        echo "</div>";
    }
}

?>
