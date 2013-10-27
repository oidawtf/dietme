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
            echo "<input type=\"checkbox\" name=\"weight_loss_".$index."\" checked value=\"".$item_dietsheet->minweightloss."-".$item_dietsheet->maxweightloss."\" /> ".$item_dietsheet->minweightloss."-".$item_dietsheet->maxweightloss." <br>";
            $index++;
        }
        
        echo "</p>";
        
        echo "<p>";
        echo "<label for=\"kind_of_diet\">Kind of diet: </label>";
        
        foreach ($input[0] as $item_dietsheet)
        {
            echo "<input type=\"checkbox\" name=\"kind_diet_".$index."\" checked value=\"".$item_dietsheet->type."\" /> ".$item_dietsheet->type." <br>";
            $index++;
        }
        
        echo "</p>";
        
        echo "<p>";
        echo "<label for=\"period_of_diet\">Period of diet: </label>";
        
        echo "<input type=\"radio\" name=\"period_diet\" value=\"14\" /> 14 days <br>";
        echo "<input type=\"radio\" name=\"period_diet\" value=\"21\" /> 21 days <br>";
        echo "<input type=\"radio\" name=\"period_diet\" value=\"31\" /> 1 month <br>";
        echo "<input type=\"radio\" name=\"period_diet\" checked value=\"186\" /> 6 months <br>";
        
        echo "</p>";
        
        echo "<p>";
        echo "<label for=\"lifestyle\">Lifestyle: </label>";
        
        foreach ($input[1] as $item_lifestyle)
        {
            echo "<input type=\"checkbox\" name=\"lifestyle_".$index."\" checked value=\"".$item_lifestyle->name."\" /> ".$item_lifestyle->name." <br>";
            $index++;
        }
        
        echo "</p>";
        
        echo "<p>";
        echo "<label for=\"eating_habits\">Eating habits: </label>";
        
        foreach ($input[2] as $item_recipe)
        {
            echo "<input type=\"checkbox\" name=\"habit_".$index."\" checked value=\"".$item_recipe->name."\" /> ".$item_recipe->name." <br>";
            $index++;
        }
        
        echo "</p>";
        
        echo "<br>";
        echo "<div>";
        echo "<input type=\"submit\" value=\"Next\" class=\"btn btn-primary right\"/>";
        echo "</div>";

        echo "</form>";
    }
}

?>
