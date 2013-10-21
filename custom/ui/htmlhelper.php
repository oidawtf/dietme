<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of htmlhelper
 *
 * @author admin
 */

class htmlhelper {

    private static $initialized = false;
    
    private static function getRoot() {
        $result = "";
        
        $path = explode('/', $_SERVER['PHP_SELF']);
        foreach ($path as $part) {
            $pos = strpos($part, 'index.php');
            if ($pos !== false)
                break;
            $result = $result."".$part."/";
        }
        
        return $result;
    }
    
    public static function initialize() {
        $document = JFactory::getDocument();
        $document->addStyleSheet(htmlhelper::getRoot()."custom/dietme.css");
    }
    
    public static function image($src, $class = NULL, $alt = NULL) {
       if (!htmlhelper::$initialized)
           htmlhelper::initialize();

       echo "<a target='_blank' href='".$src."'>";
       echo     "<img class='".$class."' src='".$src."' alt='".$alt."' />";
       echo "</a>";
    }
    
    public static function search($name) {
        echo "<form class='form-inline' method='GET' action='".$_SERVER['PHP_SELF']."'>";
        echo    "<label class='element-invisible' for='mod-search-searchword'>Search...</label>";
        echo    "<input type='text' value='Search...' size='20' class='inputbox search-query' maxlength='20' name='".$name."'
            onfocus=\"if (this.value=='Search...') this.value='';\"
            onblur=\"if (this.value=='') this.value='Search...';\"
            >";
        echo "</form>";
    }
    
    public static function caloriesTable($input) {
        caloriesTable::show($input);
    }
    
    public static function dietselectionForm($input) {
        dietselectionForm::show($input);
    }
    
    public static function dietSheetSimple($dietsheet) {
        dietSheetSimple::show($dietsheet);
    }
    
    public static function dietSheetList($list) {
        dietSheetList::show($list);
    }
    
    public static function dietSheetDetails($dietsheet) {
        dietSheetDetails::show($dietsheet);
    }
    
}

?>
