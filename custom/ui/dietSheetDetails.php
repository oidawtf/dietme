<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dietSheetDetails
 *
 * @author admin
 */

class dietSheetDetails {
    
    public static function show($dietsheet) {
        $days = count($dietsheet->recipes);
        
        if ($_GET['days'] != NULL)
            $days = $_GET['days'];
        
        $times = ceil($days / count($dietsheet->recipes));
        
        echo "<div class='items-row cols-1 row-0 row-fluid clearfix'>";
        echo    "<div class='span12'>";
        echo        "<div class='item column-1'>";
        
        htmlhelper::dietSheetSimple($dietsheet, $times);
        
        echo            "<div id='slide-days' class='accordion'>";
        for ($i = 1; $i <= count($dietsheet->recipes); $i++) {
            if ($dietsheet->recipes[$i] == NULL)
                break;
            
            echo            "<div class='accordion-group'>";
            echo                "<div class='accordion-heading'>";
            echo                    "<strong>";
            echo                        "<a class='accordion-toggle' data-toggle='collapse' data-parent='#slide-days' href='#day".$i."'>";
            echo                            $times."x Day ".($i);
            echo                            "<div class='right'>€ ".$dietsheet->getSumCostDay($i, $times)."</div>";
            echo                        "</a>";
            echo                    "</strong>";
            echo                "</div>";
            echo                "<div id='day".$i."' class='accordion-body collapse'>";
            echo                    "<div class='accordion-inner padding5'>";
            
            echo                        "<div id='slide-recipes".$i."' class='accordion'>";
            foreach ($dietsheet->recipes[$i] as $recipe) {
                echo                        "<div class='accordion-group'>";
                echo                            "<div class='accordion-heading'>";
                echo                                "<strong>";
                echo                                    "<a class='accordion-toggle' data-toggle='collapse' data-parent='#slide-recipes".$i."' href='#recipe".$i."_".$recipe->id."'>";
                echo                                        $recipe->times."x ".$recipe->name." - ".$recipe->meal;
                echo                                        "<div class='right'>€ ".$recipe->getSumCost()."</div>";
                echo                                    "</a>";
                echo                                "</strong>";
                echo                            "</div>";
                echo                            "<div id='recipe".$i."_".$recipe->id."' class='accordion-body collapse'>";
                echo                                "<div class='accordion-inner padding5'>";
                echo                                    "<dl class='contact-address dl-horizontal'>";
                echo                                        "<dt>";
                htmlhelper::image($recipe->getImage(), "image-recipe");
                echo                                        "</dt>";
                echo                                        "<dd>";
                echo                                            "<span class='contact-street'>";
                echo                                                "<p>".$recipe->description."</p>";
                echo                                            "</span>";
                echo                                        "</dd>";
                
                 echo                                                "<table class='category table table-striped table-bordered table-hover margin0'>";
                echo                                                    "<thead>";
                echo                                                        "<tr>";
                echo                                                            "<th>Name</th>";
                echo                                                            "<th>Cost €</th>";
                echo                                                            "<th>Sum €</th>";
                echo                                                        "</tr>";
                echo                                                    "</thead>";
                echo                                                    "<tbody>";
                
                $j = 0;
                foreach ($recipe->ingredients as $ingredient) {
                    echo                                                    "<tr class='cat-list-row".$j."'>";
                    echo                                                        "<td class='list-name' headers='categorylist_header_name'>".$ingredient->count."x ".$ingredient->name."</td>";
                    echo                                                        "<td class='list-cost' headers='categorylist_header_cost'>".$ingredient->cost."</td>";
                    echo                                                        "<td class='list-sumcost' headers='categorylist_header_sumcost'>".$ingredient->getSumCost()."</td>";
                    echo                                                    "</tr>";
                    $j++;
                }
                echo                                                    "</tbody>";
                echo                                                "</table>";
                
                
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
