<head>
    <meta http-equiv="refresh" content="5">
    <title>Current Block</title>
</head>

<?php

// Set the timezone to Boston, MA
date_default_timezone_set('America/New_York');

// All the necessary data is included
include('data/data-holidays-specialdays.php');

// Get current date and time
$current_date = date("Y-m-d");
$current_time = date("H:i:s");

// Debug output: current date and time
echo "Current Time: $current_time / ";
echo "Current Date: $current_date<br><br>";

// Check if today is a holiday (no school)
if (array_key_exists($current_date, $holidays)) {
    echo "School is not in session today due to: " . $holidays[$current_date][0];
    exit;
}

// Check if today is a special day (if you want to do something different for these days, adjust accordingly)
if (array_key_exists($current_date, $special_days)) {
    echo "Special day today: " . $special_days[$current_date][0] . "<br>";
    // For purposes of rotation, we still count it as a school day.
}

// --- Calculate current rotation day ---
//
// The rotation start date is assumed to be the first day of school. 
// Adjust this date as necessary.
$rotation_start_date = strtotime("2024-08-27");
$today_timestamp = strtotime($current_date);

// Count only school days from the rotation start up to today.
// A school day is defined as a weekday (Mon-Fri) that is not a holiday.
$school_day_count = 0;
$current_timestamp = $rotation_start_date;
while ($current_timestamp <= $today_timestamp) {
    $day_of_week = date("N", $current_timestamp); // 1 (Mon) to 7 (Sun)
    $date_str = date("Y-m-d", $current_timestamp);
    // Count Monday-Friday (1-5) that are not holidays.
    if ($day_of_week < 6 && !array_key_exists($date_str, $holidays)) {
        $school_day_count++;
    }
    // Increment by one day
    $current_timestamp = strtotime("+1 day", $current_timestamp);
}

// The rotation day is based on the school day count.
// If the first school day is Day 1, then:
// Rotation Day = ((school_day_count - 1) mod 8) + 1
$rotation_day = (($school_day_count - 1) % 8) + 1;

// Output the calculated school day count and rotation day for debugging
echo "School Day Count (since rotation start): $school_day_count<br><br>";
echo "Current Rotation Day: Day $rotation_day<br><br>";

// Determine the current period (based on $base_periods)
$current_period = null;
foreach ($base_periods as $period => $times) {
    // Using a half-open interval: period is active if current time is >= start and < end
    if ($current_time >= $times['start'] && $current_time < $times['end']) {
        $current_period = $period;
        break;
    }
}

// If no period found, then school is not in session
if ($current_period === null) {
    echo "School  not in session. Go play!";
    exit;
}

// Get current block for the period from the rotation schedule
$current_block = $rotation[$rotation_day][$current_period - 1]; // Adjust for zero-indexing

// Output the current period and block
echo "Current Period: Period " . $current_period . "<br>";
echo "Current Block: <strong>" . $current_block . "</strong><br><br><br>";

// Output the full schedule for today (rotation day's blocks) with each period's start and end times
echo "Classes for Today (Rotation Day $rotation_day):<br>";
echo "<ul>";

// Instead of iterating over blocks, iterate over period numbers (1 through 8)
// so we can display the period's start and end time.
for ($period = 1; $period <= count($base_periods); $period++) {
    $block = $rotation[$rotation_day][$period - 1]; // Get block for this period
    $times = $base_periods[$period]; // Get start and end times for this period
    // Build display string with block and period times
    $display = $times['start'] . "<br>" . $times['end'] . " - " . $block;
    
    // Check if this block is the current block, if so, highlight in bold.
    if ($block == $current_block) {
        echo "<li><strong>$display</strong></li>";
    } else {
        echo "<li>$display</li>";
    }
}

echo "</ul>";

?>

<style>
    li {
        margin-bottom: 0.2rem;
    }
</style>
