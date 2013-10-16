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
    
    public function selectDietSheets() {
        $connection = $this->openConnection();

        $sql = "
            SELECT
                I.id,
                I.name,
                I.description,
                I.image,
                I.cost,
                I.calories
            FROM ingredients AS I
            ;";
        
        $query = mysql_query($sql);
        
        $result = array();
        while ($row = mysql_fetch_assoc($query))
        {
            $item = new dietsheet();
            $item->id = $row['id'];
            $item->name = $row['name'];
            $result[] = $item;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result);
        
        $this->closeConnection($query);
        
        return $result;
    }
}

?>
