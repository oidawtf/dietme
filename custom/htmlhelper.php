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

    private static $initialized = false;
    
    public static function initialize() {
        $document = JFactory::getDocument();
        $document->addStyleSheet("/dietme/custom/dietme.css");
    }    
    
    public static function image($src, $class = NULL, $alt = NULL) {
        
        if (!htmlhelper::$initialized) {
            htmlhelper::initialize();
        }
        
       echo "<a target='_blank' href='".$src."'>";
       echo     "<img class='".$class."' src='".$src."' alt='".$alt."' />";
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
            htmlhelper::image($item->getImage(), "image-ingredient");
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
    
    public static function dietselectionForm($input) {
        echo "<form method='POST' action='diet-sheet-list'>";
        
        
        $index = 1;
        
        echo "<table align=\"center\" cellpadding = \"10\">";
        
        echo "<tr>";
        echo "<td>Gewichtsabnahme</td>";
        echo "<td>";
        
        foreach ($input[0] as $item_dietsheet)
        {
            echo "<input type=\"checkbox\" name=\"diet_".$index."\" value=\"".$item_dietsheet->minweightloss."-".$item_dietsheet->maxweightloss."\" checked>".$item_dietsheet->minweightloss." - ".$item_dietsheet->maxweightloss;
            $index++;
        }
          
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Programm</td>";
        echo "<td>";
        
        $index = 1;
        
        foreach ($input[0] as $item_dietsheet_type)
        {
            echo "<input type=\"checkbox\" name=\"kind_".$index."\" value=\"".$item_dietsheet_type->type."\" checked>".$item_dietsheet_type->type;
            $index++;
        }
        
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Zeitdauer</td>";
        echo "<td>";

        echo "<input type=\"radio\" name=\"period\" value=\"14\"> 14 Tage";
        echo "<input type=\"radio\" name=\"period\" value=\"21\"> 21 Tage";
        echo "<input type=\"radio\" name=\"period\" value=\"31\" checked> 31 Tage (1 Monat)";
        echo "<input type=\"radio\" name=\"period\" value=\"14\"> 14 Tage";
        echo "<input type=\"radio\" name=\"period\" value=\"186\"> 186 Tage (6 Monate)";
        
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Lebensstil</td>";
        echo "<td>";
        
        $index = 1;
        
        foreach ($input[1] as $item_lifestyle)
        {
            echo "<input type=\"checkbox\" name=\"lifestyle_".$index."\" value=\"".$item_lifestyle->name."\" checked>".$item_lifestyle->name;
            $index++;
        }
        
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Zutaten</td>";
        echo "<td>";
        
        $index = 1;
        
        foreach ($input[2] as $item_recipe)
        {
            echo "<input type=\"checkbox\" name=\"habits_".$index."\" value=\"".$item_recipe->name."\" checked>".$item_recipe->name;
            $index++;
        }
        
        echo "</td>";
        echo "</tr>";
        
        echo "</table>";
        
        
        echo    "<div>";
        echo        "<input class='btn btn-primary' type='submit' type='submit' name='choice' value='Next' />";
        echo    "</div>";
        echo "</form>";
    }
    
    private static function dietSheetSimple($dietsheet) {
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
    
    public static function dietSheetList($list) {
        
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
    
    public static function dietSheetDetails($dietsheet) {
        echo "<div class='items-row cols-1 row-0 row-fluid clearfix'>";
        echo    "<div class='span12'>";
        echo        "<div class='item column-1'>";
        htmlhelper::dietSheetSimple($dietsheet);
        
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
                htmlhelper::image($recipe->getImage(), "image-recipe");
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
