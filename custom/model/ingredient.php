<?php

class ingredient {
    
    const defaultImage = "/dietme/images/ingredients/default_ingredient.jpg";
    
    public $id;
    public $name;
    public $description;
    public $image;
    public $cost;
    public $calories;
    // amount is the weight
    public $amount;
    // the type of of the weight / or as liters
    public $amounttype;
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
