<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>

<style>

::selection {
    background-color: transparent;
    color: #000;
}

.calendar {
    display: grid;
    grid-template-columns: max-content max-content max-content;
    gap: 0rem 5rem;
    width: max-content;
    margin: 4rem auto 0;
    font-family: georgia;
    color: #333c;
    zoom: .35;
    cursor: default;
}

.calendar h1 {
    grid-column: 1/-1;
    text-align: center;
}

.calendar h3 {
    text-align: right;
    font-weight: 400;
    margin-bottom: 0.4rem;
    font-size: 1.4rem;
    letter-spacing: 2px;
    word-spacing: 12px;
    color: #999c;
}

.calendar h4 {
    text-align: left;
    margin-bottom: .1rem;
    margin-top: 2rem;
}

.calendar h1, h2, h3, h4 {
    font-family: verdana;
}

.calendar table {
    border-collapse: collapse;
    text-align: center;
    /* border: 4px solid #333; */
    box-shadow: 0px 0px 0px 1px #333;
}

.calendar tr > * {
    /* box-shadow: 0px 0px 0px 0.2px #000; */
    border: 1px solid #3333;
}

.calendar tr td:first-of-type,
.calendar tr td:last-of-type {
    background-color: #f0f0f0;
}


.calendar th {
    font-size: .8rem;
    background-color: #ddd;
    font-family: verdana;
}

.calendar tr:first-of-type {
    /* box-shadow: 0px 0px 0px 1px #333; */

}

.calendar table {
    width: initial;
    height: initial;
}

.calendar td {
    padding: 10px 15px;
    color: #333c;
    font-size: 1.3rem;
    /* opacity: .75; */
}

.calendar .snow-day span {
    color: gold;
}

.calendar .no-school span {
    color: hsl(10, 70%, 75%);
}

.calendar .half-day span {
    color: hsl(134, 55%, 55%); 
}

.calendar .important-dates span {
    color: hsl(211, 66%, 65%); 
}

.calendar .end-of-quarter span {
    color: orange; 
}

.calendar table .snow-day {
    background-color: gold;
    color: #fff; 
}

.calendar table .no-school { 
    background-color: hsl(10, 70%, 75%);
    color: #fff; 
}

.calendar table .half-day { 
    background-color: hsl(134, 55%, 55%); 
    color: #fff; 
}

.calendar table .important-dates { 
    background-color: hsl(211, 66%, 65%); 
    color: #fff; 
}

.calendar table .end-of-quarter { 
    background-color: orange; 
    color: #fff; 
}


.calendar .special-list {
    margin-top: 20px;
    font-size: 16px;
    grid-column: 3 / 4;
    grid-row: 2 / 8;
}

.calendar ul {
    border-bottom: 1px solid #3333;
    margin-bottom: .2rem;
}

.calendar li {
    font-size: 1.3rem;
    padding-bottom: .5rem;
    margin-bottom: 0rem;
    list-style: none;
}

.calendar .April li.no-school:nth-of-type(6),
.calendar .April li.no-school:nth-of-type(5),
.calendar .April li.no-school:nth-of-type(4),
.calendar .February li.no-school:nth-of-type(5),
.calendar .February li.no-school:nth-of-type(4),
.calendar .February li.no-school:nth-of-type(3),
.calendar .January li.no-school:nth-of-type(2), 
.calendar .January li.no-school:nth-of-type(1), 
.calendar .December li.no-school:nth-of-type(10),
.calendar .December li.no-school:nth-of-type(9),
.calendar .December li.no-school:nth-of-type(8),
.calendar .December li.no-school:nth-of-type(7),
.calendar .December li.no-school:nth-of-type(6),
.calendar .December li.no-school:nth-of-type(5),
.calendar .December li.no-school:nth-of-type(4),
.calendar .December li.no-school:nth-of-type(3) {
    display: none;
}

</style>

<?php
function generateCalendar($yearStart, $monthStart, $yearEnd, $monthEnd) {
    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    echo "<div class='calendar'>";
    echo "<h1>AMSA Charter School $yearStart-$yearEnd</h1>";

    $specialDates = [
        "2024-08-30" => ["Labor Day Weekend",           "no-school"],
        "2024-09-02" => ["Labor Day - No School",       "no-school"],
        "2024-10-14" => ["Indigenous Peoples Day",      "no-school"],
        "2024-11-11" => ["Veterans' Day",               "no-school"],
        "2024-11-28" => ["Thanksgiving Break",          "no-school"],
        "2024-11-29" => ["Thanksgiving Break",          "no-school"],
        "2024-12-23" => ["December Break - Start",      "no-school"],
        "2024-12-24" => ["December Break",              "no-school"],
        "2024-12-25" => ["December Break",              "no-school"],
        "2024-12-26" => ["December Break",              "no-school"],
        "2024-12-30" => ["December Break",              "no-school"],
        "2024-12-31" => ["December Break",              "no-school"],
        "2025-01-01" => ["December Break",              "no-school"],
        "2025-01-02" => ["December Break",              "no-school"],
        "2025-01-03" => ["December Break - End",        "no-school"],
        "2025-01-20" => ["Martin Luther King",          "no-school"],
        "2025-02-17" => ["February Vacation - Start",   "no-school"],
        "2025-02-18" => ["February Vacation",           "no-school"],
        "2025-02-19" => ["February Vacation",           "no-school"],
        "2025-02-20" => ["February Vacation",           "no-school"],
        "2025-02-21" => ["February Vacation - End",     "no-school"],
        "2025-04-21" => ["April Vacation - Start",      "no-school"],
        "2025-04-22" => ["April Vacation",              "no-school"],
        "2025-04-23" => ["April Vacation",              "no-school"],
        "2025-04-24" => ["April Vacation",              "no-school"],
        "2025-04-25" => ["April Vacation - End",        "no-school"],
        "2025-05-26" => ["Memorial Day - No School",    "no-school"],
        "2025-06-19" => ["Juneteenth - No School",      "no-school"],
        
        "2024-08-26" => ["New Student Orientation",         "half-day"],
        "2024-09-25" => ["Half Day - PD",                   "half-day"],
        "2024-10-30" => ["Half Day - PD",                   "half-day"],
        "2024-11-19" => ["Half Day - PD",                   "half-day"],
        "2024-11-27" => ["Half Day for all",                "half-day"],
        "2024-12-20" => ["Half Day - Staff Holiday Party",  "half-day"],
        "2025-01-08" => ["Half Day - PD",                   "half-day"],
        "2025-03-12" => ["Half Day - PD",                   "half-day"],
        "2025-04-15" => ["Half Day - PD",                   "half-day"],
        "2025-05-02" => ["Half Day for all (Prom)",         "half-day"],
        
        "2024-08-27" => ["First Day of School",             "important-dates"],
        "2024-09-19" => ["Back to School Night 6, 7, 8",    "important-dates"],
        "2024-09-20" => ["Photo Day",                       "important-dates"],
        "2024-09-24" => ["Back to School Night 9,10,11,12", "important-dates"],
        "2024-10-10" => ["PSAT",                            "important-dates"],
        "2024-10-17" => ["MAML Math Olympiad",              "important-dates"],
        "2024-11-01" => ["Photo Retake Day",                "important-dates"],
        "2024-11-06" => ["AMC 10 A",                        "important-dates"],
        "2025-01-23" => ["AMC 8",                           "important-dates"],
        "2025-05-27" => ["Senior's Celebration / Last Day", "important-dates"],
        "2025-05-30" => ["Graduation",                      "important-dates"],
        "2025-06-20" => ["Last Day of School",              "important-dates"],
        
        "2024-10-31" => ["End of Quarter 1",                "end-of-quarter"],
        "2025-01-22" => ["End of Quarter 2",                "end-of-quarter"],
        "2025-04-02" => ["End of Quarter 3",                "end-of-quarter"],
        
        "2025-02-06" => ["Snow Day",                        "snow-day"],
    ];

    // Sort the specialDates array by date
    ksort($specialDates);

    $currentYear = $yearStart;
    for ($month = $monthStart; $currentYear <= $yearEnd && ($currentYear < $yearEnd || $month <= $monthEnd); $month++) {
        if ($month > 12) {
            $month = 1;
            $currentYear++;
        }
        echo "<div>";
        echo "<h3>{$months[$month - 1]} $currentYear</h3>";
        echo "<table >";
        // echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr>";

        $firstDayOfMonth = strtotime("$currentYear-$month-01");
        $daysInMonth = date("t", $firstDayOfMonth);
        $startDay = date("w", $firstDayOfMonth);

        echo "<tr>";
        for ($i = 0; $i < $startDay; $i++) {
            echo "<td></td>";
        }

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$currentYear-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);
            $class = isset($specialDates[$date]) ? $specialDates[$date][1] : "";
            echo "<td title='$class' class='$class'>$day</td>";
            if ((($startDay + $day) % 7) == 0) echo "</tr><tr>";
        }

        while ((($startDay + $daysInMonth) % 7) != 0) {
            echo "<td></td>";
            $daysInMonth++;
        }

        echo "</tr></table>";
        echo "</div>";
    }

    echo "<div class='special-list'>";
    // Group special dates by month
    $groupedEvents = [];
    foreach ($specialDates as $date => [$desc, $class]) {
        $monthNum = substr($date, 5, 2);
        $monthName = $months[(int)$monthNum - 1];
        $groupedEvents[$monthName][] = ["date" => date("m/d", strtotime($date)), "desc" => $desc, "class" => $class];
    }

    // Display grouped events
    foreach ($groupedEvents as $monthName => $events) {
        echo "<h4>$monthName</h4><ul class='$monthName'>";
        foreach ($events as $event) {
            echo "<li class='{$event['class']}'><span>${event['date']}</span> &nbsp;&nbsp; ${event['desc']}</li>";
        }
        echo "</ul>";
    }

    echo "</div></div>";
}

generateCalendar(2024, 8, 2025, 7);
?>
