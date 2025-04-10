<style>
    :root {
        font-size: 1.25rem;
        font-family: georgia;
    }

    ul {
        font-size: .8rem;
    }

    li {
        margin-bottom: 0.2rem;
    }

    span.lunch-time {
        color: #666;
        font-size: .65rem;
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
    <meta http-equiv="refresh" content="55">
    <title>Current Block with Lunch</title>
</head>
<body>
    <div class="wrapper">
<?php
date_default_timezone_set('America/New_York');

include('data/data-holidays-specialdays.php');

// Get current date and time
$current_date = date("Y-m-d");
$current_time = date("H:i:s");

// Debug output: current date and time
echo "<div>";
echo "Current Time: $current_time / ";
echo "Current Date: $current_date<br>";
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
echo '<input type="submit" value="Select Lunch">';
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
echo "<div class='school-day-count'>";
echo "$school_day_count days down / $days_left days to go";
echo "</div>";
echo "<div class='amsa-day'>Today is a Day $rotation_day</div>";

// --- Determine the current and next period ---
$current_period = null;
$next_period = null;
$current_block = null;
$next_block = null;

// Find the current period based on the current time
foreach ($base_periods as $period => $times) {
    if ($current_time >= $times['start'] && $current_time < $times['end']) {
        $current_period = $period;
        $current_block = $rotation[$rotation_day][$period - 1];
    }
}

// Determine the next period based on the current period
if ($current_period !== null && $current_period < 8) {
    $next_period = $current_period + 1;
    $next_block = $rotation[$rotation_day][$next_period - 1];
}

// --- Display current or next period ---
if ($current_period !== null) {
    echo "<div class='current-block-period'>
        Currently in Period $current_period 
        <br>
        <strong>  
        $current_block ({$base_periods[$current_period]['start']} – {$base_periods[$current_period]['end']})
        </strong>
    </div>";
} else {
    // Check if we're between periods
    foreach ($base_periods as $p => $times) {
        if (isset($base_periods[$p + 1])) {
            $gap_start = $times['end'];
            $gap_end = $base_periods[$p + 1]['start'];
            if ($current_time >= $gap_start && $current_time < $gap_end) {
                $next_block = $rotation[$rotation_day][$p]; // $p is 1-based, matches the current period number
                echo "<div class='next-block-period'>
                    Between periods<br>
                    <strong>Next: Period " . ($p + 1) . " – $next_block ({$gap_end} – {$base_periods[$p + 1]['end']})</strong>
                </div>";
                break;
            }
        }
    }

    // If it's not during a school day timeframe at all
    if ($current_time < $base_periods[1]['start'] || $current_time >= $base_periods[8]['end']) {
        echo "No school right now. Go enjoy your day!<br>";
    }
}

// --- Display today's schedule ---
echo "<h2 class='classes-for-today'>Classes for Today (Day <strong>$rotation_day</strong>):</h2>";
echo "<ul class='todays-rotation'>";
for ($period = 1; $period <= count($base_periods); $period++) {
    if ($period == 5) {
        // For period 5, we force the start time to "11:11", regardless of lunch selection, because the overall block always starts at 11:11.
        $times = $base_periods[$period];
        $times['start'] = "11:11";
        $block_name = $rotation[$rotation_day][4];
        $lunch = $lunch_options[$lunch_choice];
        // Output both the 5th period block name and the lunch info.
        $block = "$block_name <br> <span class='lunch-time'>{$lunch['label']} ({$lunch['start']}–{$lunch['end']})</span>";
    } else {
        $block = $rotation[$rotation_day][$period - 1];
        $times = $base_periods[$period];
    }

    $display = $times['start'] . " - " . $times['end'] . " - " . $block;

    if ($period == $current_period) {
        echo "<li><strong>$display</strong></li>";
    } else {
        echo "<li>$display</li>";
    }
}
echo "</ul>";

ob_end_flush(); ?>

</div>
