<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of caloriesTable
 *
 * @author admin
 */

class caloriesTable {
    
    public static function show($input) {

        htmlhelper::initialize();
        
//        Idea to use BootStrap row / col system
//        $i = 0;
//        foreach ($input as $item) {
//            echo "<div class='row'>";
//            echo    "<div class='col-xs-12 col-md-6'>";
//            htmlhelper::image($item->getImage(), "image-ingredient");
//            echo    "</div>";
//            echo    "<div class='col-xs-12 col-md-6'>";
//            echo        "<h5>".$item->name."</h5>";
//            echo        "<p>".$item->description."</p>";
//            echo    "</div>";
//            echo "</div>";
//        }
        
        echo "<table class='category table table-striped table-bordered table-hover'>";
        echo    "<tbody>";
        $i = 0;
        foreach ($input as $item) {
            echo    "<tr class='cat-list-row".$i."'>";
            echo        "<td class='list-title padding0' headers='categorylist_header_name'>";
            htmlhelper::image($item->getImage(), "image-ingredient");
            echo            "<div class='padding5' style='margin-left: 10px;'>";
            echo                "<h5>".$item->name."</h5>";
            echo                "<p>";
            echo                    "Amount: <b>".$item->amount." ".$item->amounttype."</b><br />";
            echo                    "Calories: <b>".$item->calories."</b><br />";
            echo                "</p>";
            echo                "<p>".$item->description."</p>";
            echo            "</div>";
            echo        "</td>";
            echo    "</tr>";
            $i++;
        }
        echo    "</tbody>";
	echo "</table>";
    } 
}

?>
