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
        echo            "<td><b>";
        echo                "<pre>";
        echo                    var_dump($sql);
        echo                "</pre>";
        echo            "</b></td>";
        echo        "</tr>";
        echo        "<tr>";
        echo            "<td>query</td>";
        echo            "<td><b>";
        echo                "<pre>";
        echo                    var_dump($query);
        echo                "</pre>";
        echo            "</b></td>";
        echo        "</tr>";
        echo        "<tr>";
        echo            "<td>result</td>";
        echo            "<td><b>";
        echo                "<pre>";
        echo                    var_dump($result);
        echo                "</pre>";
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
                I.amount,
                I.amounttype,
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
            $item->amount = $row['amount'];
            $item->amounttype = $row['amounttype'];
            $item->calories = $row['calories'];
            $result[] = $item;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result);
        
        $this->closeConnection($query);
        
        return $result;
    }
    
    public function selectDietSheet($id) {
        $id = $this->format($id);

        $where = NULL;
        if ($id != NULL)
            $where = "
                WHERE
                DS.id = '".$id."'
                    ";
        
        $dietsheets = $this->selectDietSheetsIntern($where);
        if (count($dietsheets) > 0)
            return reset($dietsheets);
               
        return null;
    }
    
    private function getWeightLoss() {
        $result = array('min' => NULL, 'max' => NULL);
        
        if ($_POST == NULL)
            return $result;
        
        for ($i = 0, $count = 0; $i <= $_POST['weight_loss_id']; $i++) {
            $weightloss = $_POST['weight_loss_'.$i];
            if ($weightloss == NULL)
                continue;

            $count++;
            
            $weight = explode('-', $weightloss);
            if (count($weight) < 2)
                continue;
            
            $min = $weight[0];
            $max = $weight[1];
            
            if ($result['min'] == NULL || $result['min'] > $min)
                $result['min'] = $min;
            if ($result['max'] == NULL || $result['max'] < $max)
                $result['max'] = $max;
        }
        
        if ($count == $i)
        $result = array('min' => NULL, 'max' => NULL);

        return $result;
    }
    
    private function getFilter($filter) {
        $result = array();
        
        if ($_POST == NULL)
            return $result;
        
        for ($i = 0; $i <= $_POST[$filter.'_id']; $i++) {
            $item = $_POST[$filter.'_'.$i];
            if ($item == NULL)
                continue;
            
            $result[] = $item;
        }
        
        if (count($result) == $i)
            $result = array();
        
        return $result;
    }
    
    public function selectDietSheets($search = NULL) {
        $search = $this->format($search);

        $weightloss = $this->getWeightLoss(); 
        $minweight = $weightloss['min'];
        $maxweight = $weightloss['max'];
        $types = $this->getFilter('kind_diet');
        $lifestyles = $this->getFilter('lifestyle');
        $habits = $this->getFilter('habit');

        echo "<pre>";
        var_dump($weightloss);
        var_dump($types);
        var_dump($lifestyles);
        var_dump($habits);
        echo "</pre>";
        
        $this->debug = TRUE;
        $search = "WHERE 1 = 1";
        
        if ($minweight != NULL)
            $search = $search." AND DS.minweightloss <= '".$minweight."'";
        if ($maxweight != NULL)
            $search = $search." AND DS.maxweightloss >= '".$maxweight."'";
        
        if ($types != NULL && count($types) > 0) {
            $search = $search." AND (DS.type = '".$types[0]."'";
            for ($i = 1; $i < count($types); $i++)
                $search = $search." OR DS.type = '".$types[$i]."'";
            $search = $search.")";
        }
        
        if ($lifestyles != NULL && count($lifestyles) > 0) {
            $search = $search." AND (DS.name_lifestyle == '".$lifestyles[0]."'";
            for ($i = 1; $i > count($lifestyles); $i++)
                $search = $search." OR DS.name_lifestyle == '".$lifestyles[$i]."'";
            $search = $search.")";
        }
        
        return $this->selectDietSheetsIntern($search);
    }
    
    private function selectDietSheetsIntern($where = NULL) {
        $connection = $this->openConnection();
        
        $sql = "
            SELECT
                DS.id AS id_dietsheet,
                DS.name AS name_dietsheet,
                DS.image AS image_dietsheet,
                DS.description AS description_dietsheet,
                DS.minweightloss,
                DS.maxweightloss,
                DS.type,
                LS.id_lifestyle,
                LS.name AS name_lifestyle,
                LS.description AS description_lifestyle
            FROM
                dietsheets AS DS
                LEFT OUTER JOIN (
                    SELECT
                        DL.f_dietsheets AS id_dietsheet,
                        DL.f_lifestyles AS id_lifestyle,
                        LS.name,
                        LS.description
                    FROM
                        _dietsheets_lifestyles AS DL, lifestyles AS LS
                    WHERE
                        DL.f_lifestyles = LS.id
                ) AS LS ON LS.id_dietsheet = DS.id
            ".$where."
            ;";
        
        $query = mysql_query($sql);
        
        $result = array();
        while ($row = mysql_fetch_assoc($query))
        {
            $id = $row['id_dietsheet'];
            
            if (!array_key_exists($id, $result)) {
                $dietsheet = new dietsheet();
                $dietsheet->id = $id;
                $dietsheet->name = $row['name_dietsheet'];
                $dietsheet->image = $row['image_dietsheet'];
                $dietsheet->description = $row['description_dietsheet'];
                $dietsheet->minweightloss = $row['minweightloss'];
                $dietsheet->maxweightloss = $row['maxweightloss'];
                $dietsheet->type = $row['type'];
                $dietsheet->lifestyles = array();
                $result[$id] = $dietsheet;
            }

            $lifestyle = new lifestyle();
            $lifestyle->id = $row['id_lifestyle'];
            $lifestyle->name = $row['name_lifestyle'];
            $lifestyle->description = $row['description_lifestyle'];
            
            $result[$id]->lifestyles[] = $lifestyle;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result);
        
        $this->closeConnection($query);
        
        return $result;
    }
    
    public function selectIngredientsByDietsheet($id) {
        $connection = $this->openConnection();
        
        $id = $this->format($id);
        
        $sql = "
            SELECT
                REI.id_recipe,
                REI.name_recipe,
                REI.description_recipe,
                REI.image_recipe,
                DR.day,
                DR.times,
                DR.meal,
                REI.id_ingredients,
                REI.count,
                REI.name_ingredient,
                REI.description_ingredient,
                REI.image_ingredient,
                REI.cost,
                REI.amount,
                REI.amounttype,
                REI.calories
            FROM
                _dietsheets_recipes AS DR
                RIGHT OUTER JOIN (
                    SELECT
                        RE.id AS id_recipe,
                        RE.name AS name_recipe,
                        RE.description AS description_recipe,
                        RE.image AS image_recipe,
                        RI.id_ingredients,
                        RI.count,
                        RI.name AS name_ingredient,
                        RI.description AS description_ingredient,
                        RI.image AS image_ingredient,
                        RI.cost,
                        RI.amount,
                        RI.amounttype,
                        RI.calories
                    FROM
                        recipes AS RE
                        LEFT OUTER JOIN (
                            SELECT
                                RI.f_recipes AS id_recipes,
                                RI.f_ingredients AS id_ingredients,
                                RI.count,
                                IG.name,
                                IG.description,
                                IG.image,
                                IG.cost,
                                IG.amount,
                                IG.amounttype,
                                IG.calories
                            FROM
                                _recipes_ingredients AS RI,
                                ingredients AS IG
                            WHERE
                                RI.f_ingredients = IG.id
                        ) AS RI ON RI.id_recipes = RE.id
                ) AS REI ON REI.id_recipe = DR.f_recipes
            WHERE
                DR.f_dietsheets = '".$id."'
            ;";
        
        $query = mysql_query($sql);
        
        $result = array();
        while ($row = mysql_fetch_assoc($query))
        {
            $id = $row['id_ingredients'];
            
            if (array_key_exists($id, $result)){
                $result[$id]->count = $result[$id]->count + $row['count'] * $row['times'];
                continue;
            }
            
            $ingredient = new ingredient();
            $ingredient->id = $id;
            $ingredient->amount = $row['amount'];
            $ingredient->amounttype = $row['amounttype'];
            $ingredient->count = $row['count'] * $row['times'];
            $ingredient->name = $row['name_ingredient'];
            $ingredient->description = $row['description_ingredient'];
            $ingredient->image = $row['image_ingredient'];
            $ingredient->cost = $row['cost'];
            $ingredient->calories = $row['calories'];
            
            $result[$id] = $ingredient;
        }
        
        if ($this->debug) {
            $sum = 0;
            echo "<pre>";
            foreach ($result as $ing) {
                echo $ing->count."x ".$ing->name." --> € ".$ing->count * $ing->cost."<br />";
                $sum = $sum + $ing->count * $ing->cost;
            }
            echo "<b>SUM: € ".$sum."</b>";
            echo "<br />";
            echo "<br />";
            echo "Tipp: Add ?dietsheet=[id of dietsheet] to the url to display a different one (e.g.: ?dietsheet=2)<br />";
            echo "</pre>";
            $this->displayResult($connection, $sql, $query, $result);
        }
        
        $this->closeConnection($query);
        
        return $result;
    }
    
    public function selectRecipesByDietsheet($id) {
        $connection = $this->openConnection();
        
        $id = $this->format($id);
        
        $sql = "
            SELECT
                REI.id_recipe,
                REI.name_recipe,
                REI.description_recipe,
                REI.image_recipe,
                DR.day,
                DR.times,
                DR.meal,
                REI.id_ingredients,
                REI.count,
                REI.name_ingredient,
                REI.description_ingredient,
                REI.image_ingredient,
                REI.cost,
                REI.amount,
                REI.amounttype,
                REI.calories
            FROM
                _dietsheets_recipes AS DR
                RIGHT OUTER JOIN (
                    SELECT
                        RE.id AS id_recipe,
                        RE.name AS name_recipe,
                        RE.description AS description_recipe,
                        RE.image AS image_recipe,
                        RI.id_ingredients,
                        RI.count,
                        RI.name AS name_ingredient,
                        RI.description AS description_ingredient,
                        RI.image AS image_ingredient,
                        RI.cost,
                        RI.amount,
                        RI.amounttype,
                        RI.calories
                    FROM
                        recipes AS RE
                        LEFT OUTER JOIN (
                            SELECT
                                RI.f_recipes AS id_recipes,
                                RI.f_ingredients AS id_ingredients,
                                RI.count,
                                IG.name,
                                IG.description,
                                IG.image,
                                IG.cost,
                                IG.amount,
                                IG.amounttype,
                                IG.calories
                            FROM
                                _recipes_ingredients AS RI,
                                ingredients AS IG
                            WHERE
                                RI.f_ingredients = IG.id
                        ) AS RI ON RI.id_recipes = RE.id
                ) AS REI ON REI.id_recipe = DR.f_recipes
            WHERE
                DR.f_dietsheets = '".$id."'
            ;";
        
        $query = mysql_query($sql);
        
        $result = array();
        while ($row = mysql_fetch_assoc($query))
        {
            $day = $row['day'];
            $id = $row['id_recipe'];
            
            if (!array_key_exists($day, $result)){
                $result[$day] = array();
            }
            
            if (!array_key_exists($id, $result[$day])) {
                $recipe = new recipe();
                $recipe->id = $id;
                $recipe->name = $row['name_recipe'];
                $recipe->description = $row['description_recipe'];
                $recipe->times = $row['times'];
                $recipe->meal = $row['meal'];
                $recipe->image = $row['image_recipe'];
                $recipe->ingredients = array();
                $result[$day][$id] = $recipe;
            }
            
            $ingredient = new ingredient();
            $ingredient->id = $row['id_ingredients'];
            $ingredient->amount = $row['amount'];
            $ingredient->amounttype = $row['amounttype'];
            $ingredient->count = $row['count'];
            $ingredient->name = $row['name_ingredient'];
            $ingredient->description = $row['description_ingredient'];
            $ingredient->image = $row['image_ingredient'];
            $ingredient->cost = $row['cost'];
            $ingredient->calories = $row['calories'];
            
            $result[$day][$id]->ingredients[] = $ingredient;
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
    
    public function selectUserInput() {
        $connection = $this->openConnection();
        
        $result = array();
        
        $result_dietsheet = array();
        $result_lifestyle = array();
        $result_recipe  = array();
        
        $sql = "
            SELECT DISTINCT
                minweightloss,
                maxweightloss,
                type
            FROM dietsheets
            ORDER by minweightloss, maxweightloss
            ;";
        
        $query = mysql_query($sql);
        
        while ($row = mysql_fetch_assoc($query))
        {
            $dietsheet = new dietsheet();
            $dietsheet->minweightloss = $row['minweightloss'];
            $dietsheet->maxweightloss = $row['maxweightloss'];
            $dietsheet->type = $row['type'];
            $result_dietsheet[] = $dietsheet;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result_dietsheet);
        
        $sql = "
            SELECT
                name
            FROM lifestyles
            ;";
        
        $query = mysql_query($sql);
        
        while ($row = mysql_fetch_assoc($query))
        {
            $lifestyle = new lifestyle();
            $lifestyle->name = $row['name'];
            $result_lifestyle[] = $lifestyle;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result_lifestyle);
        
        $sql = "
            SELECT
                name
            FROM recipes
            ;";
        
        $query = mysql_query($sql);
        
        while ($row = mysql_fetch_assoc($query))
        {
            $recipe = new recipe();
            $recipe->name = $row['name'];
            $result_recipe[] = $recipe;
        }
        
        if ($this->debug)
            $this->displayResult($connection, $sql, $query, $result_recipe);

        $this->closeConnection($query);
        
        $result[0] = $result_dietsheet;
        $result[1] = $result_lifestyle;
        $result[2] = $result_recipe;
        
        return $result;
    }
}

?>
