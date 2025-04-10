<style>
    :root {
        font-size: 1.5rem;
    }
</style>

<?php
ob_start(); // Start output buffering

// Clear lunch cookie if user clicked the clear button via GET parameter.
if (isset($_GET['clear_lunch'])) {
    setcookie("lunch_choice", "", time() - 3600);
    unset($_COOKIE['lunch_choice']);
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}
?>
<head>
    <meta http-equiv="refresh" content="5">
    <title>Current Block with Lunch</title>
</head>

<?php
date_default_timezone_set('America/New_York');

include('data/data-holidays-specialdays.php');

// Get current date and time
$current_date = date("Y-m-d");
$current_time = date("H:i:s");

// Debug output: current date and time
echo "Current Time: $current_time / ";
echo "Current Date: $current_date<br>";

// Define lunch options array
$lunch_options = [
    '1' => ['label' => 'Lunch 1', 'start' => '11:11', 'end' => '11:33'],
    '2' => ['label' => 'Lunch 2', 'start' => '11:33', 'end' => '11:56'],
    '3' => ['label' => 'Lunch 3', 'start' => '11:56', 'end' => '12:18']
];

// If a lunch choice is provided via GET and is valid, set/update the cookie.
if (isset($_GET['lunch_choice']) && isset($lunch_options[$_GET['lunch_choice']])) {
    setcookie("lunch_choice", $_GET['lunch_choice'], strtotime('tomorrow'));
    $_COOKIE['lunch_choice'] = $_GET['lunch_choice'];
}

// If there's no lunch choice stored in a cookie, show the selection form.
if (!isset($_COOKIE['lunch_choice']) || !isset($lunch_options[$_COOKIE['lunch_choice']])) {
    echo '<form method="get">';
    echo '<label>Select your lunch for today:</label><br>';
    foreach ($lunch_options as $key => $option) {
        echo "<input type='radio' name='lunch_choice' value='$key' required> {$option['label']} ({$option['start']} - {$option['end']})<br>";
    }
    echo '<input type="submit" value="Submit">';
    echo '</form>';
    ob_end_flush();
    exit;
}

$lunch_choice = $_COOKIE['lunch_choice'];

// Display a button to clear the current lunch selection cookie.
echo '<form method="get" style="margin-bottom: 1em;">';
echo '<input type="hidden" name="clear_lunch" value="1">';
echo '<input type="submit" value="Clear Lunch Selection">';
echo '</form>';

// Check if today is a holiday (no school)
if (array_key_exists($current_date, $holidays)) {
    echo "School is not in session today due to: " . $holidays[$current_date][0];
    ob_end_flush();
    exit;
}

// Check if today is a special day
if (array_key_exists($current_date, $special_days)) {
    echo "Special day today: " . $special_days[$current_date][0] . "<br>";
    // The day still counts for the rotation.
}

// --- Calculate current rotation day ---
$rotation_start_date = strtotime("2024-08-27");
$today_timestamp = strtotime($current_date);
$school_day_count = 0;
$current_timestamp = $rotation_start_date;
while ($current_timestamp <= $today_timestamp) {
    $day_of_week = date("N", $current_timestamp);
    $date_str = date("Y-m-d", $current_timestamp);
    if ($day_of_week < 6 && !array_key_exists($date_str, $holidays)) {
        $school_day_count++;
    }
    $current_timestamp = strtotime("+1 day", $current_timestamp);
}

$rotation_day = (($school_day_count - 1) % 8) + 1;
$days_left = 180 - $school_day_count;
echo "$school_day_count days down / $days_left days to go <br>";
echo "Today is a Day $rotation_day<br>";

// --- Determine the current period ---
$current_period = null;
foreach ($base_periods as $period => $times) {
    if ($current_time >= $times['start'] && $current_time < $times['end']) {
        $current_period = $period;
        break;
    }
}

$current_block = null;
if ($current_period == 5) {
    $lunch = $lunch_options[$lunch_choice];
    if ($current_time >= $lunch['start'] && $current_time < $lunch['end']) {
        $current_block = $lunch['label'];
    } else {
        $current_block = $rotation[$rotation_day][4]; // period 5 uses index 4
    }
} elseif ($current_period !== null) {
    $current_block = $rotation[$rotation_day][$current_period - 1];
} else {
    echo "School not in session. Go play!";
    ob_end_flush();
    exit;
}

echo "Currently in Period " . $current_period . "<br>";
echo "Current Block: <strong>" . $current_block . "</strong><br><br>";

// --- Display today's schedule ---
echo "Classes for Today (Day $rotation_day):<br>";
echo "<ul>";
for ($period = 1; $period <= count($base_periods); $period++) {
    if ($period == 5) {
        // For period 5, we force the start time to "11:11", regardless of lunch selection,
        // because the overall block always starts at 11:11.
        $times = $base_periods[$period];
        $times['start'] = "11:11";
        $block_name = $rotation[$rotation_day][4];
        $lunch = $lunch_options[$lunch_choice];
        // Output both the 5th period block name and the lunch info.
        $block = "$block_name – {$lunch['label']} ({$lunch['start']}–{$lunch['end']})";
    } else {
        $block = $rotation[$rotation_day][$period - 1];
        $times = $base_periods[$period];
    }

    $display = $times['start'] . "<br>" . $times['end'] . " - " . $block;

    if (
        ($period == 5 && (strpos($block, $current_block) !== false)) ||
        ($block == $current_block)
    ) {
        echo "<li><strong>$display</strong></li>";
    } else {
        echo "<li>$display</li>";
    }
}
echo "</ul>";

ob_end_flush();
?>

<style>
    li {
        margin-bottom: 0.2rem;
    }
</style>
