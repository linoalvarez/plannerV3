<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap');

    :root {
        font-size: 1.25rem;
        font-family: georgia;
    }

    h2 {
        font-family: Helvetica;
        font-size: 1.2rem;
        border-bottom: 2px solid #3333;
        padding-bottom: .5rem;
    }

    .wrapper {
        width: max-content;
        padding: 3rem 3rem 3rem;
        border: 1px solid #3333;
        border-radius: 5px;
        margin: 3rem auto 0rem;
        box-shadow: 0 0 10px -1px #3339;
        position: relative;
    }

    input[type="submit"] {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        padding: .5rem 1rem;
        border-radius: 5px;
    }

    .info {
        padding: 1rem;
        background-color: #eee;
        text-align: center;
    }

    .info div {
        margin-bottom: 0.5rem;

    }

    ul {
        font-size: .8rem;
        font-family: 'Roboto Mono';
        letter-spacing: -1px;
        list-style: decimal;
    }

    li {
        padding: 0.2rem 1.5rem 0.2rem 0.5rem;
    }
    
    li strong {
        padding: 0.2rem 0.5rem 0.2rem 0.5rem;
        background-color: darkblue;
        color: darkorange;
    }

    span.lunch-time {
        color: #666;
        font-size: .65rem;
    }

    .now {
        font-weight: 900;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .time-left {
        font-style: italic;
    }

    .red {
        color: red;
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
    <meta http-equiv="refresh" content="1550">
    <title>Current Block with Lunch</title>
</head>
<body>
    <div class="wrapper">
<?php
date_default_timezone_set('America/New_York');

include('data/data-holidays-specialdays.php');

// Load the LAS CSV for class names (assuming CSV columns: block,class_name,...)
$las_schedule = [];
if (($handle = fopen("data/data-LAS.csv", "r")) !== FALSE) {
    // Read header row
    fgetcsv($handle);
    while (($data = fgetcsv($handle)) !== FALSE) {
        $block = trim($data[0]);       // Trim block name to ensure consistency
        $class_name = trim($data[1]);    // Trim class name
        $las_schedule[$block] = $class_name;
    }
    fclose($handle);
}

// Get current date and time
$current_date = date("Y-m-d");
$current_time = date("H:i:s");

// Debug output: current date and time
echo "<div class='now'>";
echo "Date: $current_date / ";
echo "Time: $current_time";
echo "</div>";

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

// If there's no lunch choice stored in a cookie, show the selection form with clickable labels.
if (!isset($_COOKIE['lunch_choice']) || !isset($lunch_options[$_COOKIE['lunch_choice']])) {
    echo '<form method="get">';
    echo '<label>Select your lunch for today:</label><br><br>';
    foreach ($lunch_options as $key => $option) {
        // Create a unique ID for each radio input.
        $input_id = 'lunch_' . $key;
        echo "<input type='radio' id='$input_id' name='lunch_choice' value='$key' required>";
        echo "<label for='$input_id'>{$option['label']} ({$option['start']} - {$option['end']})</label><br><br>";
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
echo '<input type="submit" value="Select Lunch">';
echo '</form>';

echo '<div class="info">';

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
echo "<div class='school-day-count'>";
echo "$school_day_count days down / $days_left days to go";
echo "</div>";
echo "<div class='amsa-day'>Today is a Day $rotation_day</div>";

// --- Determine the current and next period ---
$current_period = null;
$next_period = null;
$current_block = null;
$next_block = null;

// Special handling for Period 5 (includes lunch)
$is_in_lunch_window = false;
$lunch_start = $lunch_options[$lunch_choice]['start'];
$lunch_end = $lunch_options[$lunch_choice]['end'];

// If current time is between 11:11 and 12:18, we consider it Period 5.
if ($current_time >= '11:11:00' && $current_time < '12:18:00') {
    $current_period = 5;
    $current_block = $rotation[$rotation_day][4];
    $is_in_lunch_window = true;
} else {
    // Normal period detection for all periods except 5.
    foreach ($base_periods as $period => $times) {
        if ($current_time >= $times['start'] && $current_time < $times['end']) {
            $current_period = $period;
            $current_block = $rotation[$rotation_day][$period - 1];
            break; // Stop at first matching period.
        }
    }
}

// Determine the next period
if ($current_period !== null && $current_period < 8) {
    $next_period = $current_period + 1;
    $next_block = $rotation[$rotation_day][$next_period - 1];
}

// --- Display current or next period with time remaining ---
if ($current_period !== null) {
    echo "<div class='current-block-period'>";
    echo "Currently in Period $current_period<br>";
    echo "<strong>$current_block ({$base_periods[$current_period]['start']} – ";
    // For Period 5, override the end time to 12:18.
    if ($current_period == 5) {
        echo "12:18";
        $period_end_ts = strtotime("12:18:00");
    } else {
        echo "{$base_periods[$current_period]['end']})";
        $period_end_ts = strtotime($base_periods[$current_period]['end']);
    }
    echo "</strong>";
    
    // Calculate time remaining in current period.
    $now_ts = strtotime($current_time);
    $diff = $period_end_ts - $now_ts;
    if ($diff > 0) {
        $minutes = floor($diff / 60);
        $seconds = $diff % 60;
        echo "<div class='time-left'>Time remaining: <strong class='red'>{$minutes}m {$seconds}s</strong></div>";
    }
    
    // Add lunch info if in Period 5
    if ($current_period == 5) {
        echo "<br><span class='lunch-time'>{$lunch_options[$lunch_choice]['label']} ({$lunch_start}–{$lunch_end})</span>";
    }
    echo "</div>";
    echo "</div>"; // Close info div
} else {
    // Between periods logic
    foreach ($base_periods as $p => $times) {
        if (isset($base_periods[$p + 1])) {
            $gap_start = $times['end'];
            $gap_end = $base_periods[$p + 1]['start'];
            if ($current_time >= $gap_start && $current_time < $gap_end) {
                $next_block = $rotation[$rotation_day][$p]; // p is 1-based
                echo "<div class='next-block-period'>
                    Between periods<br>
                    <strong>Next: Period " . ($p + 1) . " – $next_block ({$gap_end} – {$base_periods[$p + 1]['end']})</strong>
                </div>";
                break;
            }
        }
    }
    if ($current_time < $base_periods[1]['start'] || $current_time >= $base_periods[8]['end']) {
        echo "School not in session. Go play!<br>";
    }
}

// --- Display today's schedule ---
echo "</div>";
echo "<div class='schedule'>";
echo "<h2 class='classes-for-today'>Today Schedule (Day <strong>$rotation_day</strong>)</h2>";
echo "<ul class='todays-rotation'>";
for ($period = 1; $period <= count($base_periods); $period++) {
    if ($period == 5) {
        // For Period 5, force start time to "11:11" and include lunch info.
        $times = $base_periods[$period];
        $times['start'] = "11:11";
        $block_name = $rotation[$rotation_day][4];
        $lunch = $lunch_options[$lunch_choice];
        // Look up class name using trimmed block name.
        $class_name = isset($las_schedule[trim($block_name)]) ? $las_schedule[trim($block_name)] : 'N/A';
        $block = "$block_name  $class_name <br> <span class='lunch-time'>{$lunch['label']} ({$lunch['start']}–{$lunch['end']})</span>";
    } else {
        $block_name = $rotation[$rotation_day][$period - 1];
        $times = $base_periods[$period];
        $class_name = isset($las_schedule[trim($block_name)]) ? $las_schedule[trim($block_name)] : 'N/A';
        $block = "$block_name  $class_name";
    }
    $display = $times['start'] . " - " . $times['end'] . " <b>" . $block . "</b>";
    if ($period == $current_period) {
        echo "<li><strong>$display</strong></li>";
    } else {
        echo "<li>$display</li>";
    }
}
echo "</ul>";
echo "</div>";

ob_end_flush();
?>
    </div>
</body>
