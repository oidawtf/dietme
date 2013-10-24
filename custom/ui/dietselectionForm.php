<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dietselectionForm
 *
 * @author admin
 */

class dietselectionForm {
    
    public static function show($input) {
        htmlhelper::initialize();
        
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
}

?>
