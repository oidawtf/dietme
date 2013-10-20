<?php

class dbService {
    
    private $host;
    private $db;
    private $user;
    private $password;
    
    private $debug = NULL;
    
    public function __construct($debug = NULL) {
        $configuration = new JConfig();

        $this->host = $configuration->host;
        $this->user = $configuration->user;
        $this->password = $configuration->password;
        $this->db = $configuration->db;
        
        if ($debug != NULL)
        $this->debug = $debug;
        
        $document = JFactory::getDocument();
        $style = '.sqlerror {'
                    . 'background-color: buttonface;'
                    . 'border-collapse: separate;'
                    . '}';
        $document->addStyleDeclaration($style);
    }
    
    private static function format($input)
    {
        $input = stripslashes($input);
        $input = mysql_real_escape_string($input);
        return $input;
    }
    
    private function displayResult($connection, $sql, $query, $result) {
        echo "<br />";
        echo "<br />";
        echo "<table cellpadding='5' border='1' class='sqlerror'>";
        echo    "<tbody>";
        
        if (mysql_errno($connection) != NULL) {
            echo    "<tr>";
            echo        "<td>mysql_errno</td>";
            echo        "<td><b>".mysql_errno($connection)."</b></td>";
            echo    "</tr>";
        }
        if (mysql_errno($connection) != NULL) {
            echo    "<tr>";
            echo        "<td>mysql_error</td>";
            echo        "<td><b>".mysql_error($connection)."</b></td>";
            echo    "</tr>";
        }
        
        echo        "<tr>";
        echo            "<td>sql</td>";
        echo            "<td><b>".$sql."</b></td>";
        echo        "</tr>";
        echo        "<tr>";
        echo            "<td>query</td>";
        echo            "<td><b>";
        echo                var_dump($query);
        echo            "</b></td>";
        echo        "</tr>";
        echo        "<tr>";
        echo            "<td>result</td>";
        echo            "<td><b>";
        echo                var_dump($result);
        echo            "</b></td>";
        echo        "</tr>";
        echo    "</tbody>";
        echo "</table>";
        echo "<br />";
        echo "<br />";
    }
    
    private function openConnection()
    {
         $connection = mysql_connect($this->host, $this->user, $this->password) or die("cannot connect");
         mysql_query("SET NAMES 'utf8'");

         if (mysqli_connect_errno($connection))
         {
             printf("Connect failed: %s\n", mysqli_connect_error());
             exit();
         }
         
         mysql_select_db($this->db) or die("cannot connect");
         
         return $connection;
    }
    
    private function closeConnection($buffer) {
        mysql_free_result($buffer);
        mysql_close();
    }
    
    public function selectIngredients($search = NULL) {
        $connection = $this->openConnection();
        
        $search = $this->format($search);

        $where = "";
        if ($search != NULL)
            $where = "
                WHERE
                I.name LIKE '%".$search."%'
                    ";
        
        $sql = "
            SELECT
                I.id,
                I.name,
                I.description,
                I.image,
                I.cost,
                I.calories
            FROM ingredients AS I
            ".$where."
            ;";
        
        $query = mysql_query($sql);
        
        $result = array();
        while ($row = mysql_fetch_assoc($query))
        {
            $item = new ingredient();
            $item->id = $row['id'];
            $item->name = $row['name'];
            $item->description = $row['description'];
            $item->image = $row['image'];
            $item->cost = $row['cost'];
            $item->calories = $row['calories'];
            $result[] = $item;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result);
        
        $this->closeConnection($query);
        
        return $result;
    }
    
    public function selectDietSheets($search = NULL) {
        $connection = $this->openConnection();
        
        $search = $this->format($search);

        $where = "";
        if ($search != NULL)
            $where = "
                WHERE
                DS.name LIKE '%".$search."%'
                    ";
        
        $sql = "
            SELECT
                DS.id,
                DS.name,
                DS.description,
                DS.minweightloss,
                DS.maxweightloss,
                DS.type
            FROM dietsheets AS DS
            ".$where."
            ;";
        
        $query = mysql_query($sql);
        
        $result = array();
        while ($row = mysql_fetch_assoc($query))
        {
            $item = new dietsheet();
            $item->id = $row['id'];
            $item->name = $row['name'];
            $item->description = $row['description'];
            $item->minweightloss = $row['minweightloss'];
            $item->maxweightloss = $row['maxweightloss'];
            $item->type = $row['type'];
            $result[] = $item;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result);
        
        $this->closeConnection($query);
        
        return $result;
    }
    
    public function selectLifestyles($search = NULL) {
        $connection = $this->openConnection();
        
        $search = $this->format($search);

        $where = "";
        if ($search != NULL)
            $where = "
                WHERE
                L.name LIKE '%".$search."%'
                    ";
        
        $sql = "
            SELECT
                L.id,
                L.name,
                L.description
            FROM lifestyles AS L
            ".$where."
            ;";
        
        $query = mysql_query($sql);
        
        $result = array();
        while ($row = mysql_fetch_assoc($query))
        {
            $item = new lifestyle();
            $item->id = $row['id'];
            $item->name = $row['name'];
            $item->description = $row['description'];
            $result[] = $item;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result);
        
        $this->closeConnection($query);
        
        return $result;
    }
    
    public function selectRecipes($search = NULL) {
        $connection = $this->openConnection();
        
        $search = $this->format($search);

        $where = "";
        if ($search != NULL)
            $where = "
                WHERE
                R.name LIKE '%".$search."%'
                    ";
        
        $sql = "
            SELECT
                R.id,
                R.name,
                R.description,
                R.image
            FROM recipes AS R
            ".$where."
            ;";
        
        $query = mysql_query($sql);
        
        $result = array();
        while ($row = mysql_fetch_assoc($query))
        {
            $item = new recipe();
            $item->id = $row['id'];
            $item->name = $row['name'];
            $item->description = $row['description'];
            $item->image = $row['image'];
            $result[] = $item;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result);
        
        $this->closeConnection($query);
        
        return $result;
    }
    
    public function showUserInput() {
        $connection = $this->openConnection();
        
        $sql = "
            SELECT
                concat(minweightloss,'-',maxweightloss) minmax
            FROM dietsheets
            ;";
        
        $query = mysql_query($sql);
        
        echo "<form action=\"form.php\" method=\"POST\">";
        echo "<table align=\"center\" cellpadding = \"10\">";
        
        echo "<tr>";
        echo "<td>Gewichtsabnahme</td>";
        echo "<td>";
        
        $index = 1;
        
        while ($row = mysql_fetch_assoc($query))
        {
            echo "<input type=\"checkbox\" name=\"diet_".$index."\" value=\"".$row['minmax']."\" checked>".$row['minmax'];
            $index++;
        }
        
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Programm</td>";
        echo "<td>";
        
        $sql = "
            SELECT
                type
            FROM dietsheets
            ;";
        
        $query = mysql_query($sql);
        
        $index = 1;
        
        while ($row = mysql_fetch_assoc($query))
        {
            echo "<input type=\"checkbox\" name=\"kind_".$index."\" value=\"".$row['type']."\" checked>".$row['type'];
            $index++;
        }
        
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Zeitdauer</td>";
        echo "<td>";

        echo "<input type=\"radio\" name=\"period\" value=\"14\"> 14 Tage";
        echo "<input type=\"radio\" name=\"period\" value=\"21\"> 21 Tage";
        echo "<input type=\"radio\" name=\"period\" value=\"31\" checked> 31 Tage (1 Monat)";
        echo "<input type=\"radio\" name=\"period\" value=\"14\"> 14 Tage";
        echo "<input type=\"radio\" name=\"period\" value=\"186\"> 186 Tage (6 Monate)";
        
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Lebensstil</td>";
        echo "<td>";
        
        $sql = "
            SELECT
                name
            FROM lifestyles
            ;";
        
        $query = mysql_query($sql);
        
        $index = 1;
        
        while ($row = mysql_fetch_assoc($query))
        {
            echo "<input type=\"checkbox\" name=\"lifestyle_".$index."\" value=\"".$row['name']."\" checked>".$row['name'];
            $index++;
        }
        
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Zutaten</td>";
        echo "<td>";
        
        $sql = "
            SELECT
                name
            FROM recipes
            ;";
        
        $query = mysql_query($sql);
        
        $index = 1;
        
        while ($row = mysql_fetch_assoc($query))
        {
            echo "<input type=\"checkbox\" name=\"habits_".$index."\" value=\"".$row['name']."\" checked>".$row['name'];
            $index++;
        }
        
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td colspan=\"2\" align=\"center\">";
        echo "<input type=\"submit\" value=\"Weiter\">";
        echo "</td>";
        echo "</tr>";
        
        echo "</table>";
 
        echo "</form>";

        $this->closeConnection($query);
    }
}

?>
