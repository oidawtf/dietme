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
        echo "<form method='POST' action='diet-sheet-list'>";
        echo    "<input type='text' name='test' />";
        echo    "<div>";
        echo        "<input class='btn btn-primary' type='submit' type='submit' name='choice' value='Next' />";
        echo    "</div>";
        echo "</form>";
    }
    
    public static function dietSheetList($input) {
        
//            $item->id = $row['id_dietsheet'];
//            $item->name = $row['name_dietsheet'];
//            $item->description = $row['description_dietsheet'];
//            $item->minweightloss = $row['minweightloss'];
//            $item->maxweightloss = $row['maxweightloss'];
//            $item->type = $row['type'];
//            $item->lifestyle_id = $row['id_lifestyle'];
//            $item->lifestyle_name = $row['name_lifestyle'];
//            $item->lifestyle_description = $row['description_lifestyle'];
        $i = 0;
        echo "<div class='blog'>";
        foreach ($input as $item) {
            echo "<div class='items-row cols-1 row-".$i." row-fluid clearfix'>";
            echo    "<div class='span12'>";
            echo        "<div class='item column-1'>";
            echo            "<div class='page-header'>";
            echo                "<h2><a href='diet-sheet-details?dietsheet=".$item->id."'>".$item->name."</a></h2>";
            echo            "</div>";
            echo            $item->description;
            echo        "</div>";
            echo    "</div>";
            echo "</div>";
        }
        echo "</div>";
    }
    
    public static function dietSheetDetails($dietsheet, $recipes) {
        
        $document = JFactory::getDocument();
        $document->addScript("http://getbootstrap.com/2.3.2/assets/js/bootstrap-carousel.js");
        
        $document->addScriptDeclaration("
            $(document).ready(function() {
    $('#myCarousel').carousel({
    //options here
    });
});
");
    
        
              echo "<div class='carousel slide' id='myCarousel'>";
              echo "  <div class='carousel-inner'>";
              echo "    <div class='item next left'>";
              echo "      <img alt='1' src=''>";
              echo "    </div>";
              echo "    <div class='item'>";
              echo "      <img alt='2' src=''>";
              echo "    </div>";
              echo "    <div class='item active left'>";
              echo "      <img alt='3' src=''>";
              echo "    </div>";
              echo "  </div>";
              echo "</div>";

        
        
        
        echo "<div class='items-row cols-1 row-0 row-fluid clearfix'>";
        echo    "<div class='span12'>";
        echo        "<div class='item column-1'>";
        echo            "<div class='page-header'>";
        echo                "<h2><a href='diet-sheet-details?dietsheet=".$dietsheet->id."'>".$dietsheet->name."</a></h2>";
        echo            "</div>";
        
        echo            "<div id='slide-recipes' class='accordion'>";
        foreach ($recipes as $recipe) {
            echo            "<div class='accordion-group'>";
            echo                "<div class='accordion-heading'>";
            echo                    "<strong>";
            echo                        "<a class='accordion-toggle' data-toggle='collapse' data-parent='#slide-recipes' href='#recipe".$recipe->id."'>".$recipe->name."</a>";
            echo                    "</strong>";
            echo                "</div>";
            echo                "<div id='recipe".$recipe->id."' class='accordion-body collapse'>";
            echo                    "<div class='accordion-inner'>";
            echo                        "<dl class='contact-address dl-horizontal'>";
            echo                            "<dt>";
            echo                                "<span class='jicons-icons'>";
            echo                                    "<img alt='Address: ' src='/dietme_max/media/contacts/images/con_address.png'>";
            echo                                "</span>";
            echo                            "</dt>";
            echo                            "<dd>";
            echo                                "<span class='contact-street'>";
            echo                                    $recipe->description;
            echo                                    "<br>";
            echo                                "</span>";
            echo                            "</dd>";
            echo                        "</dl>";
            echo                    "</div>";
            echo                "</div>";
            echo            "</div>";

        }
        echo            "</div>";
        
        echo        "</div>";
        echo    "</div>";
        echo "</div>";
    }
}

?>
