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
    
    public static function image($src, $alt = NULL) {
       echo "<a target='_blank' href='".$src."'>";
       echo     "<img style='margin: 1px; width: 100%;' src='".$src."' alt='".$alt."' />";
       echo "</a>";
    }
    
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
            htmlhelper::image($item->getImage());
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
        echo "<form method='POST' action='diet-sheet-list'>";
        echo    "<input type='text' name='test' />";
        echo    "<div>";
        echo        "<input class='btn btn-primary' type='submit' type='submit' name='choice' value='Next' />";
        echo    "</div>";
        echo "</form>";
    }
    
    public static function dietSheetList($input) {
        $i = 0;
        echo "<div class='blog'>";
        foreach ($input as $item) {
            echo "<div class='items-row cols-1 row-".$i." row-fluid clearfix'>";
            echo    "<div class='span12'>";
            echo        "<div class='item column-1'>";
            echo            "<div class='page-header'>";
            echo                "<h2><a href='diet-sheet-details?dietsheet=".$item->id."'>".$item->name."</a></h2>";
            echo            "</div>";
            echo            "<div class='article-info muted'>";
            echo                "<dl class=article-info>";
            echo                    "<dt class='article-info-term'>Details</dt>";
            echo                    "<dd>Minmal weight loss: ".$item->minweightloss." kg</dd>";
            echo                    "<dd>Maximal weight loss: ".$item->maxweightloss." kg</dd>";
            echo                    "<dd>Diet type: ".$item->type."</dd>";
            echo                    "<dd>Goes with lifestyles: ".$item->getLifestyles()."</dd>";
            echo                "</dl>";
            echo            "</div>";
            echo            $item->description;
            echo        "</div>";
            echo    "</div>";
            echo "</div>";
        }
        echo "</div>";
    }
    
    public static function dietSheetDetails($dietsheet) {
        
        echo "<div class='items-row cols-1 row-0 row-fluid clearfix'>";
        echo    "<div class='span12'>";
        echo        "<div class='item column-1'>";
        echo            "<div class='page-header'>";
        echo                "<h2><a href='diet-sheet-details?dietsheet=".$dietsheet->id."'>".$dietsheet->name."</a></h2>";
        echo            "</div>";
        
        echo            "<div id='slide-days' class='accordion'>";
        for ($i = 1; $i <= count($dietsheet->recipes); $i++) {
            if ($dietsheet->recipes[$i] == NULL)
                break;
            
            echo            "<div class='accordion-group'>";
            echo                "<div class='accordion-heading'>";
            echo                    "<strong>";
            echo                        "<a class='accordion-toggle' data-toggle='collapse' data-parent='#slide-days' href='#day".$i."'>Day ".($i)."</a>";
            echo                    "</strong>";
            echo                "</div>";
            echo                "<div id='day".$i."' class='accordion-body collapse'>";
            echo                    "<div class='accordion-inner'>";
            
            echo                        "<div id='slide-recipes".$i."' class='accordion'>";
            foreach ($dietsheet->recipes[$i] as $recipe) {
                echo                        "<div class='accordion-group'>";
                echo                            "<div class='accordion-heading'>";
                echo                                "<strong>";
                echo                                    "<a class='accordion-toggle' data-toggle='collapse' data-parent='#slide-recipes".$i."' href='#recipe".$i."_".$recipe->id."'>".$recipe->times."x ".$recipe->name." - ".$recipe->meal."</a>";
                echo                                "</strong>";
                echo                            "</div>";
                echo                            "<div id='recipe".$i."_".$recipe->id."' class='accordion-body collapse'>";
                echo                                "<div class='accordion-inner'>";
                echo                                    "<dl class='contact-address dl-horizontal'>";
                echo                                        "<dt>";
                htmlhelper::image($recipe->getImage());
                echo                                        "</dt>";
                echo                                        "<dd>";
                echo                                            "<span class='contact-street'>";
                echo                                                $recipe->description;
                echo                                                "<br>";
                echo                                            "</span>";
                echo                                        "</dd>";
                echo                                   "</dl>";
                echo                               "</div>";
                echo                           "</div>";
                echo                        "</div>";
            }
            echo                        "</div>";

            echo                    "</div>";
            echo                "</div>";
            echo            "</div>";
        }
        echo            "</div>";
        
        echo        "</div>";
        echo        "<input class='btn btn-primary' type='submit' type='submit' name='order' value='Order' />";
        echo    "</div>";
        echo "</div>";
    }
}

?>
