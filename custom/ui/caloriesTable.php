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
        echo "<table class='category table table-striped table-bordered table-hover'>";
	echo    "<thead>";
        echo        "<tr>";
	echo            "<th style='width: 150px;'></th>";
        echo            "<th>Name</th>";
        echo            "<th style='width: 80px;'>Amount</th>";
        echo            "<th style='width: 80px;'>Calories</th>";
        echo        "</tr>";
        echo    "</thead>";
        echo    "<tbody>";
        $i = 0;
        foreach ($input as $item) {
            echo    "<tr class='cat-list-row".$i."'>";
            echo        "<td style='margin: 0px; padding: 0px 1px 0px 0px;' class='list-picture' headers='categorylist_header_picture'>";
            htmlhelper::image($item->getImage(), "image-ingredient");
            echo        "</td>";
            echo        "<td class='list-title' headers='categorylist_header_name'>";
            echo            "<h5>".$item->name."</h5>";
            echo            "<p>".$item->description."</p>";
            echo        "</td>";
            echo        "<td class='list-author' headers='categorylist_header_amount'>".$item->amount." ".$item->amounttype."</td>";
            echo        "<td class='list-edit' headers='categorylist_header_calories'>".$item->calories."</td>";
            echo    "</tr>";
            $i++;
        }
        echo    "</tbody>";
	echo "</table>";
    } 
}

?>
