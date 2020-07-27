<?php
$hours = $workArea = $date = NULL;
$hours_msg = $workArea_msg = $date_msg = NULL;

function validateForm() {
    global $hours, $workArea, $hours_msg, $workArea_msg, $date, $date_msg;
    $valid = true;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
        if (empty($_POST['hours']) || $_POST['hours'] < 0 || $_POST['hours'] > 24 || !is_numeric($_POST['hours'])) {
            $hours_msg = "Please enter your hours for the day as a positive number <24 with no leading zeroes (ex: 8) <br />";
            if($valid) $valid = false;
        }
        else
            $hours = trim($_POST['hours']);

        $workAreas = array("curds", "garden", "hammocks", "kettle", "pack help", "pack honcho",
            "seed racks", "seeds", "tofu hut", "trays");
        if (empty($_POST['work-area']) || !in_array(strtolower($_POST['work-area']), $workAreas)) {
            $workArea_msg = "Please pick a work area from the list <br />";
            if($valid) $valid = false;
        }
        else
            $workArea = trim($_POST['work-area']);

        if(empty($_POST['date'])) {
            $date_msg = "Please enter the date that you worked these hours";
            if($valid) $valid = false;
        }
        else
            $date = trim($_POST['date']);
        
        return $valid;
    }
}
$confirm = validateForm();
?>

<?php
    if ($confirm) {
        echo "Successfully submitted " . intval($hours) . " hours at the $workArea for $date!";
    }
?>     