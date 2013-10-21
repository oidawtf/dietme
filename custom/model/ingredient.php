<?php

class ingredient {
    
    const defaultImage = "/dietme/images/ingredients/default_ingredient.jpg";
    
    public $id;
    public $name;
    public $description;
    public $image;
    public $cost;
    public $calories;
    // amount is the weight in g (1000g == 1kg)
    public $amount;
    // count is the count of how much is needed of this instance for a specific recipe
    public $count;
    
    public function getImage() {
        if ($this->image == NULL || $this->image == "") {
            return self::defaultImage;
        }
        
        return $this->image;
    }
    
}

?>
