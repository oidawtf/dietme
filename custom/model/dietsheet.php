<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dietsheet
 *
 * @author admin
 */
class dietsheet {

    const defaultImage = "/dietme/images/dietsheets/default_dietsheet.jpg";
    
    public $id;
    public $name;
    public $description;
    public $image;
    public $minweightloss;
    public $maxweightloss;
    public $type;
    public $lifestyles;
    public $recipes;
    
    public function getLifestyles() {
        $result = "";
        
        foreach ($this->lifestyles as $lifestyle)
            $result = $result."".$lifestyle->name.", ";

        $result = trim($result, ", ");
        return $result;
    }
    
    public function getImage() {
        if ($this->image == NULL || $this->image == "") {
            return self::defaultImage;
        }
        
        return $this->image;
    }
    
    public function getSumCost($times = 1) {
        $result = 0;
        
        if ($this->recipes == null)
            return null;
        
        for ($i = 1; $i <= count($this->recipes); $i++)
            $result = $result + $this->getSumCostDay($i, $times);
        
        return $result;
    }
    
    public function getSumCostDay($day, $times = 1) {
        $result = 0;
        
        if ($this->recipes == null || $this->recipes[$day] == null)
            return $result;
        
        foreach ($this->recipes[$day] as $recipe)
            $result = $result + $recipe->getSumCost();
        
        return $result * $times;
    }
}

?>
