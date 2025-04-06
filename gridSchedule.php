<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>

<style>
    table {
        border-collapse: collapse;
        font-family: georgia;
        /* min-width: 1024px; */
        color: #333;
        width: max-content;
        zoom: .6;
        transform: rotate(-90deg) translate(-16rem , -5rem);
    }

    table th {
        background-color: #3335;
        color: #fff;
        font-family: verdana;
        font-size: .75rem;
        font-weight: 400;
    }

    table tr > * {
        padding: 0.8rem 0.5rem;
;
    }

    table .fake-td {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    table .block-name {
        font-weight: 900;
        opacity: .5;
        /* filter: invert(1); */
        /* background: #eee; */
    }

    table .class-name {
        font-weight: 900;
        font-size: 1.5rem;
        text-align: center;
        grid-column: 1/-1;
        opacity: .8;
    }

    table .room {
        text-align: right;
        opacity: .5;
        }


</style>

<?php
// Define base periods
$base_periods = [
    1 => ['start' => '07:55', 'end' => '08:40'],
    2 => ['start' => '08:44', 'end' => '09:29'],
    3 => ['start' => '09:33', 'end' => '10:18'],
    4 => ['start' => '10:22', 'end' => '11:07'],
    5 => ['start' => '11:33', 'end' => '12:18'],
    6 => ['start' => '12:22', 'end' => '13:07'],
    7 => ['start' => '13:11', 'end' => '13:56'],
    8 => ['start' => '14:00', 'end' => '14:45']
];

// Define AMSA rotation schedule
$rotation = [
    1 => ['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1'],
    2 => ['B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'A2'],
    3 => ['C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'A1', 'B1'],
    4 => ['D2', 'E2', 'F2', 'G2', 'H2', 'A2', 'B2', 'C2'],
    5 => ['E1', 'F1', 'G1', 'H1', 'A1', 'B1', 'C1', 'D1'],
    6 => ['F2', 'G2', 'H2', 'A2', 'B2', 'C2', 'D2', 'E2'],
    7 => ['G1', 'H1', 'A1', 'B1', 'C1', 'D1', 'E1', 'F1'],
    8 => ['H2', 'A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2']
];

// Read data from the CSV file and store in an associative array
$data_file = fopen("data.csv", "r");
$class_data = [];
while (($row = fgetcsv($data_file)) !== FALSE) {
    $block = $row[0];           // Block (A1, B2, etc.)
    $class_name = $row[1];      // Class name (Math, Physics, etc.)
    $teacher = $row[2];         // Teacher name (Mr. SoAndSo, Mrs. ThisAndThat)
    $room = $row[3];            // Room number (201, 211, etc.)
    $student_email = $row[4];   // Student email
    $student_name = $row[5];    // Student name

    // Store the class data in the array, indexed by the block
    $class_data[$block] = [
        'class_name' => $class_name,
        'teacher' => $teacher,
        'room' => $room
    ];
}
fclose($data_file);

// Start the grid table
echo "<table border='1'>";

// Table header with days
echo "<tr><th>Time</th>";
for ($day = 1; $day <= 8; $day++) {
    echo "<th>Day " . $day . "</th>";
}
echo "</tr>";

// Loop through periods
foreach ($base_periods as $period_number => $times) {
    echo "<tr>";
    
    // First column: Time range
    echo "<th><div class='time-range'>" . $times['start'] . " </div><div> " . $times['end'] . "</div></th>";
    
    // Columns for each AMSA day
    for ($day = 1; $day <= 8; $day++) {
        $block = $rotation[$day][$period_number - 1]; // Get block for the period
        
        if (isset($class_data[$block])) {
            $class = $class_data[$block];
            echo "<td class='" .  $block . "'>";
            
            echo "<div class='fake-td'>";

            echo "   <div class='block-name'>" . $block . "</div>";
            echo "   <div class='room'>" . $class['room'] . "</div>";

            echo "   <div class='class-name'>" . $class['class_name'] . "</div>";

            echo "</div>";

            // echo "<div class='teacher'>" . $class['teacher'] . "</div>";
            echo "</td>";
        } else {
            echo "<td></td>"; // Empty cell if no data
        }
    }
    
    echo "</tr>";
}

// Close table
echo "</table>";
