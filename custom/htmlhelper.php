<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of htmlhelper
 *
 * @author admin
 */
class htmlhelper {
    
    public static function search($name) {
        echo "<form class='form-inline' method='GET' action='".$_SERVER['PHP_SELF']."'>";
        echo    "<label class='element-invisible' for='mod-search-searchword'>Search...</label>";
        echo    "<input type='text' value='Search...' size='20' class='inputbox search-query' maxlength='20' name='".$name."'
            onfocus=\"if (this.value=='Search...') this.value='';\"
            onblur=\"if (this.value=='') this.value='Search...';\"
            >";
        echo "</form>";
    }
    
    public static function caloriesTable($input) {
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
            echo            "<a target='_blank' href='".$item->image."'>";
            echo                "<img style='margin: 1px; width: 100%;' src=".$item->image." />";
            echo            "</a>";
            echo        "</td>";
            echo        "<td class='list-title' headers='categorylist_header_name'>";
            echo            "<h5>".$item->name."</h5>";
            echo            "<p>".$item->description."</p>";
            echo        "</td>";
            echo        "<td class='list-author' headers='categorylist_header_amount'>".$item->amount."</td>";
            echo        "<td class='list-edit' headers='categorylist_header_calories'>".$item->calories."</td>";
            echo    "</tr>";
            $i++;
        }
        echo    "</tbody>";
	echo "</table>";
    }
    
    public static function dietselectionForm() {
        echo "<form method='POST' action=''>";
        echo    "<input type='text' name='test' />";
        echo    "<div>";
        echo        "<input class='btn btn-primary' type='submit' type='submit' name='choice' value='Next' />";
        echo    "</div>";
        echo "</form>";
    }
    
}

?>
