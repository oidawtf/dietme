<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of orderForm
 *
 * @author admin
 */
class orderForm {
    
    public static function show($input) {
        if ($input == NULL)
            return;
        
        $times = 1;
        if (isset($_GET['times']))
            $times = $_GET['times'];
        
        echo "<table class='category table table-striped table-bordered table-hover margin0'>";
        echo    "<thead>";
        echo        "<tr>";
        echo            "<th>Name</th>";
        echo            "<th>Cost €</th>";
        echo            "<th>Sum €</th>";
        echo        "</tr>";
        echo    "</thead>";
        echo    "<tbody>";
                
        $i = 0;
        $sum = 0;
        foreach ($input as $ingredient) {
            echo     "<tr class='cat-list-row".$i."'>";
            echo        "<td class='list-name' headers='categorylist_header_name'>".$ingredient->count * $times."x ".$ingredient->name."</td>";
            echo        "<td class='list-cost' headers='categorylist_header_cost'>€ ".$ingredient->cost."</td>";
            echo        "<td class='list-sumcost' headers='categorylist_header_sumcost'>€ ".$ingredient->getSumCost() * $times."</td>";
            echo    "</tr>";
            $sum = $sum + $ingredient->getSumCost() * $times;
            $i++;
        }
        echo    "</tbody>";
        echo "</table>";
        echo "<p><b>TOTAL: € ".$sum."</b></p>";
        echo "<form method='POST' action=''>";
        echo    "<input type='hidden' name='dietsheet' value='".$sum."' />";
        echo    "<input class='btn btn-primary right' type='submit' type='submit' value='Confirm Order' />";
        echo "</form>";
    }
}

?>
