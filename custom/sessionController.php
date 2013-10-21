<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sessionController
 *
 * @author admin
 */
class sessionController {
    
    const sessionIDSelection = 'dietme_selection';
    
    public static function hasSelection() {
        return $_SESSION[self::sessionIDSelection] != NULL;
    }
    
    public static function saveSelection($selection) {
        $_SESSION[self::sessionIDSelection] = $selection;
    }
    
    public static function loadSelection() {
        return $_SESSION[self::sessionIDSelection];
    }  
}

?>
