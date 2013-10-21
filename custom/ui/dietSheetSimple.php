<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dietSheetSimple
 *
 * @author admin
 */

class dietSheetSimple {
    
    public static function show($dietsheet) {
        echo "<div class='page-header'>";
        htmlhelper::image($dietsheet->getImage(), "image-dietsheet");
        echo    "<h2><a href='diet-sheet-details?dietsheet=".$dietsheet->id."'>".$dietsheet->name."</a></h2>";
        echo "</div>";
        echo "<div class='article-info muted'>";
        echo     "<dl class=article-info>";
        echo         "<dt class='article-info-term'>Details</dt>";
        echo         "<dd>Minmal weight loss: ".$dietsheet->minweightloss." kg</dd>";
        echo         "<dd>Maximal weight loss: ".$dietsheet->maxweightloss." kg</dd>";
        echo         "<dd>Diet type: ".$dietsheet->type."</dd>";
        echo         "<dd>Goes with lifestyles: ".$dietsheet->getLifestyles()."</dd>";
        echo     "</dl>";
        echo "</div>";
        echo $dietsheet->description;
        echo "<br />";
        echo "<br />";
        echo "<br />";
    }
}

?>
