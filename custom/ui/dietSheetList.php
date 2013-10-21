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
        
        echo "<pre>";
        echo "&#36;_POST:";
        echo "<br />";
        echo "<br />";
        var_dump($_POST);
        echo "</pre>";
        
        $i = 0;
        echo "<div class='blog'>";
        foreach ($list as $dietsheet) {
            echo "<div class='items-row cols-1 row-".$i." row-fluid clearfix'>";
            echo    "<div class='span12'>";
            echo        "<div class='item column-1'>";
            htmlhelper::dietSheetSimple($dietsheet);
            echo        "</div>";
            echo    "</div>";
            echo "</div>";
        }
        echo "</div>";
    }
}

?>
