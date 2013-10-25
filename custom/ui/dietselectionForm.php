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
        
        $index = 1;
        
        echo "<form method='POST' action='diet-sheet-list' class=\"cssform_userinput\">";
        
        echo "<p>";
        echo "<label for=\"desired_weight_loss\">Desired weight loss: </label>";
        
        foreach ($input[0] as $item_dietsheet)
        {
            echo "<input type=\"checkbox\" name=\"weight_loss_".$index."\" checked /> ".$item_dietsheet->minweightloss."-".$item_dietsheet->maxweightloss." <br>";
            $index++;
        }
        
        echo "</p>";
        
        echo "<p>";
        echo "<label for=\"kind_of_diet\">Kind of diet: </label>";
        
        foreach ($input[0] as $item_dietsheet)
        {
            echo "<input type=\"checkbox\" name=\"kind_diet_".$index."\" checked /> ".$item_dietsheet->type." <br>";
            $index++;
        }
        
        echo "</p>";
        
        echo "<p>";
        echo "<label for=\"period_of_diet\">Period of diet: </label>";
        
        echo "<input type=\"checkbox\" name=\"period_diet_1\" checked /> 14 days <br>";
        echo "<input type=\"checkbox\" name=\"period_diet_2\" checked /> 21 days <br>";
        echo "<input type=\"checkbox\" name=\"period_diet_3\" checked /> 1 month <br>";
        echo "<input type=\"checkbox\" name=\"period_diet_4\" checked /> 6 months <br>";
        
        echo "</p>";
        
        echo "<p>";
        echo "<label for=\"lifestyle\">Lifestyle: </label>";
        
        foreach ($input[1] as $item_lifestyle)
        {
            echo "<input type=\"checkbox\" name=\"lifestyle_".$index."\" checked /> ".$item_lifestyle->name." <br>";
            $index++;
        }
        
        echo "</p>";
        
        echo "<p>";
        echo "<label for=\"eating_habits\">Eating habits: </label>";
        
        foreach ($input[2] as $item_recipe)
        {
            echo "<input type=\"checkbox\" name=\"habit_".$index."\" checked /> ".$item_recipe->name." <br>";
            $index++;
        }
        
        echo "</p>";
        
        echo "<br>";
        echo "<div>";
        echo "<input type=\"submit\" value=\"Next\" />";
        echo "</div>";

        echo "</form>";
    }
}

?>
