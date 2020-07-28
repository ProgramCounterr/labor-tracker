<?php
/** Make a table of all the work areas and populate it (if they don't exist already) */
function initWorkAreasDb() {
    $work_areas = array(["Curds", 1000],
                    ["curds", 1000],
                    ["Garden", 1000],
                    ["Hammocks", 1000],
                    ["Kettle", 1000],
                    ["Pack Help", 1000],
                    ["Pack Honcho", 1000],
                    ["Seed Racks", 1000],
                    ["Seeds", 1000],
                    ["Tofu Hut", 1000],
                    ["Trays", 1000]
                );

    require('model/connect-db.php');
    $query = "SELECT * FROM `work_areas`";
    $statement = $db->prepare($query);
    $statement->execute();	
    $result = $statement->fetchAll();
    //The table doesn't exit
    if (!$result){                
            $query = "CREATE TABLE work_areas(
            area_name VARCHAR(255) PRIMARY KEY,
            labor_balance INT NOT NULL,
            CHECK (labor_balance>0)
            )";
            $statement = $db->prepare($query);
            $statement->execute();
            $statement->closeCursor();
    }
    foreach ($work_areas as $work_area){
        $query = "SELECT * FROM `work_areas` WHERE area_name=:area";
        $statement = $db->prepare($query);
        $statement->bindValue(':area', $work_area[0]);
        $statement->execute();
        $result = $statement->fetch();
        //The work area doesn't exist
        if (!$result){
            $que = "INSERT INTO `work_areas` (area_name, labor_balance) VALUES(:area, :labor)";
            $state = $db->prepare($que);
            $state->bindValue(':area', (String)$work_area[0]);
            $state->bindValue(':labor', (int)$work_area[1]);

            $r = $state->execute();
        }
    }
}
initWorkAreasDb();
?>