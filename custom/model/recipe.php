<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of recipe
 *
 * @author admin
 */
class recipe {

    const defaultImage = "/dietme/images/recipes/default_recipe.jpg";
    
    public $id;
    public $name;
    public $description;
    public $image;
    public $ingredients;
    public $times;
    public $meal;
    
    public function getImage() {
        if ($this->image == NULL || $this->image == "") {
            return self::defaultImage;
        }
        
        return $this->image;
    }

    public function getSumCost() {
        $result = 0;
        
        if ($this->ingredients == null)
            return $result;
        
        foreach ($this->ingredients as $ingredient)
            $result = $result + $ingredient->getSumCost();
        
        return $result * $this->times;
    }
}

?>
