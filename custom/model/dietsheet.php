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
}

?>
