
<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>

<?php include('css/CSS.php'); ?>

<?php include('css/CSS-extra.php'); ?>

<?php
    $start_date = strtotime("2024-08-27");  // Start date
    $end_date = strtotime("2025-06-12");    // End date

include('data/data-holidays-specialdays.php');


// Read data from the CSV file and store in an associative array
$data_file = fopen("data/data.csv", "r");
$class_data = [];
$students = [];
$header_skipped = false;

while (($row = fgetcsv($data_file)) !== FALSE) {
    // Skip the header row
    if (!$header_skipped) {
        $header_skipped = true;
        continue;
    }

    $block = $row[0];           // Block (A1, B2, etc.)
    $class_name = $row[1];      // Class name (Math, Physics, etc.)
    $teacher = $row[2];         // Teacher name (Mr. SoAndSo, Mrs. ThisAndThat)
    $room = $row[3];            // Room number (201, 211, etc.)
    $student_email = $row[4];   // Student email
    $student_name = $row[5];    // Student name

    // Store the class data in the array, indexed by the block
    $class_data[$student_email][$block] = [
        'class_name' => $class_name,
        'teacher' => $teacher,
        'room' => $room
    ];

    // Store student information
    if (!isset($students[$student_email])) {
        $students[$student_email] = $student_name;
    }
}
fclose($data_file);

// Get selected student from dropdown, if any
$selected_student = $_GET['student'] ?? '';
$student_name = $students[$selected_student] ?? '';
$student_email = $selected_student;
$class_data_for_student = $class_data[$selected_student] ?? [];

// Sort students by last name
// Split the student name into first and last name, then sort
uasort($students, function($a, $b) {
    // Assume names are "First Last"
    $last_name_a = explode(" ", $a)[1] ?? $a; // Get last name, if possible
    $last_name_b = explode(" ", $b)[1] ?? $b; // Get last name, if possible

    return strcmp($last_name_a, $last_name_b);
});

$amsa_day = 1;
$school_day_count = 0;
?>

<form class="no-print" method="GET">
    <label for="student">Student:</label>
    <select name="student" id="student" onchange="this.form.submit()">
        <option value="">-- Select Student --</option>
        <?php foreach ($students as $email => $name): ?>
            <!-- Skip the header value, which could be "student_name" -->
            <?php if ($name !== 'student_name'): ?>
                <option value="<?= htmlspecialchars($email) ?>" <?= $selected_student == $email ? 'selected' : '' ?>>
                    <?= htmlspecialchars($name) ?>
                </option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($student_name): ?>
    <div class="wrapper">
        <div class="student-info">
            <img src="img/AMSA_RGB_Icon_Blk.jpg">
            <img src="img/AMSA_RGB_Icon_Blk.jpg">
            <h1>AMSA <?= date("Y", $start_date) ?>/<?= date("Y", $end_date) ?></h1>
            <h2><?= htmlspecialchars($student_name) ?></h2>
            <h3><?= htmlspecialchars($student_email) ?></h3>
            <?php //include('gridSchedule.php'); ?>
            <div class="grid-schedule">
                <table border='1'>
                    <thead>
                        <tr>
                            <th>Time</th>
                            <?php for ($day = 1; $day <= 8; $day++): ?>
                                <th>Day <?= $day ?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($base_periods as $period => $times): ?>
                            <tr>
                                <th><?= $times['start'] ?><br><?= $times['end'] ?></th>
                                <?php for ($day = 1; $day <= 8; $day++): 
                                    $block_name = $rotation[$day][$period - 1];
                                    $class_info = $class_data_for_student[$block_name] ?? null;
                                    ?>
                                    <td>
                                        <?php if ($class_info): ?>
                                            <div class="block"><b><?= $block_name ?></b></div>
                                            <div class="class-name"><?= htmlspecialchars($class_info['class_name']) ?></div>
                                            <div class="teacher"><?= htmlspecialchars($class_info['teacher']) ?></div>
                                            <div class="room"><?= htmlspecialchars($class_info['room']) ?></div>
                                        <?php else: ?>
                                            <div class="no-class">No class</div>
                                        <?php endif; ?>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class='school-day'></div> -->
         <div class='school-day'></div>
         <div class='school-day no-school-days special-days'>
        <?php
         
  //       
          
// Function to generate the unordered list for each category
function generateList($array, $category) {
    $filtered = array_filter($array, function($event) use ($category) {
        return $event[1] === $category;
    });

    if (!empty($filtered)) {

        echo "<div>";
        echo "<h2>" . ucfirst(str_replace("-", " ", $category)) . "</h2>";
        echo "<ul>";
        foreach ($filtered as $date => $event) {
            echo "<li><strong>$date</strong> {$event[0]}</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}

// Generate the lists for each category
$categories = ["no-school", "half-day", "important-dates", "end-of-quarter"];
foreach ($categories as $category) {
    generateList($holidays, $category);
    generateList($special_days, $category);
}
?>

         </div>
         <div class='school-day'></div>

        <?php
        while ($start_date <= $end_date) {
            $current_date = date("Y-m-d", $start_date);
            $day_of_week = date("N", $start_date); // 1 (Monday) to 7 (Sunday)
            
            // Exclude weekends and holidays
            if ($day_of_week < 6 && !array_key_exists($current_date, $holidays)) {
                $weekday = date("l", $start_date);
                $date_str = date("d M Y", $start_date);
                $amsa_day_str = "Day $amsa_day";

                // Check if the current day is a special school day
                $special_day_str = isset($special_days[$current_date]) ? "<div class='special-day'>{$special_days[$current_date][0]}</div>" : '';
                
                echo "<div class='school-day'>";
                echo "<header>";
                echo "<div class='date'>$date_str</div>";
                echo "<div class='weekday'>$weekday</div>";
                echo "<div class='amsa-day'>$amsa_day_str</div>";
                echo $special_day_str;  // Display special day if exists
                echo "</header>";
                
                echo "<main>";
                foreach ($base_periods as $period => $times) {
                    $block_name = $rotation[$amsa_day][$period - 1];
                    $class_info = $class_data_for_student[$block_name] ?? null;
                    $class_str = $class_info ? "<span class='class-name'>{$class_info['class_name']}</span> <span class='teacher-name'>{$class_info['teacher']}</span> <span class='room-number'>{$class_info['room']}</span>" : "No class info available";
                    
                    echo "<div class='period'>";
                    
                    echo "<div class='br-checkbox'> <label> <input type='checkbox' /> <span></span> </label> </div>";
                    echo "<div class='br-checkbox'> <label> <input type='checkbox' /> <span></span> </label> </div>";
                    echo "<div class='br-checkbox'> <label> <input type='checkbox' /> <span></span> </label> </div>";

                    echo "<div class='period-time'>";
                    echo "<div class='start-time'>{$times['start']}</div>";
                    echo "<div class='block-name'>$block_name</div>";
                    echo "<div class='end-time'>{$times['end']}</div>";
                    echo "</div>";
                    echo "<div class='class-info'>$class_str</div>";
                    echo "</div>";
                }
                echo "</main>";
                
                $school_day_count++;
                $total_school_days = 180;
                $remaining_school_days = $total_school_days - $school_day_count;
                
                echo "<footer>";
                echo "<div class='school-day-count'>$school_day_count/$remaining_school_days</div>";
                echo "</footer>";
                echo "</div>";

                $amsa_day = ($amsa_day % 8) + 1;
            }
            $start_date = strtotime("+1 day", $start_date);
        }
        ?>

<div class="school-day">
    <?php include('calendar4planner.php'); ?>
</div>

<div class="school-day back-logo">
    <img src="img/AMSA_RGB_Logo_Blk_Academy_and_Values.jpg">
</div>

    </div>
<?php endif; ?>