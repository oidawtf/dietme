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
        if (htmlhelper::$initialized)
            return;
        
        $document = JFactory::getDocument();
        $document->addStyleSheet(htmlhelper::getRoot()."custom/dietme.css");
        //$document->addStyleSheet(htmlhelper::getRoot()."media/system/css/bootstrap.css");
    }
    
    public static function easteregg() {
        $input = array();
        
        $orange = new ingredient();
        $orange->name = "Hey Apple!";
        $orange->description = "
            Hey, hey, Apple, hey!<br />
            Whoa! You're the biggest orange I've ever seen!<br />
            I'm not a grape, I'm an orange!<br />
            TOE-MAY-TOE!<br />
            Wanna hear the most annoying sound in the world?<br />
            I wish for a pot of gold!<br />
            What a jip-sy.<br />
            You're an apple!<br />
            Hey! Are you related to Ms. Fortune Cookie?<br />
            Hey, guys, what's so funny?<br />
            Poe-Tay-Toe?<br />
            I'm bored<br />
            Yuck-yuck-yuck-yuck-yuck-yuck.<br /> 
            ";
        $orange->image = "/dietme/images/easteregg/easteregg_hey_apple_orange.jpg";
        $orange->amount = "???";
        $orange->calories = "???";
        $input[] = $orange;
        
        $apple = new ingredient();
        $apple->name = "What? What? What is it?!";
        $apple->description = "
            Yeah, that joke was funny the first four hundred times you said it.<br />
            (sarcastically) Yeah, that was hilarious.<br />
            What!?!?<br />
            (confused) What kind of question is that? I don't even have arms; how am I going to do one push-up?<br />
            No, stop it!<br />
            Okay, you've made your point! Stop it.....<br />
            Would you please be quiet?!<br />
            For crying out loud, would you stop yammering for longer than three seconds? I can't even hear myself think! (grunts)<br />
            ";
        $apple->image = "/dietme/images/easteregg/easteregg_hey_apple_apple.jpg";
        $apple->amount = "???";
        $apple->calories = "???";
        $input[] = $apple;
        
        caloriesTable::show($input);
    }
    
    public static function image($src, $class = NULL, $alt = NULL) {
       
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
    
    public static function dietSheetSimple($dietsheet, $times = NULL, $days = NULL) {
        dietSheetSimple::show($dietsheet, $times, $days);
    }
    
    public static function dietSheetList($list) {
        dietSheetList::show($list);
    }
    
    public static function dietSheetDetails($dietsheet) {
        dietSheetDetails::show($dietsheet);
    }
    
    public static function orderForm($input) {
        orderForm::show($input);
    }
}

?>
