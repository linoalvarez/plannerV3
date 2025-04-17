<?php
// Google Sheet as CSV
$url = 'https://docs.google.com/spreadsheets/d/18gst8B_WyjeJRhnfEhlzqa7msoGRl1aqSgG8u6HZvM0/export?format=csv&gid=1146835200';

// Load and parse CSV
$csv = file_get_contents($url);
$lines = array_map('str_getcsv', explode("\n", trim($csv)));

// Separate header from data
$header = array_map('trim', $lines[0]);
$data = array_slice($lines, 1);

// Convert to associative array
$rows = [];
foreach ($data as $line) {
    if (count($line) !== count($header)) continue; // Skip malformed rows
    $rows[] = array_combine($header, array_map('trim', $line));
}

// Sort by 'Date' and then 'Section'
usort($rows, function($a, $b) {
    $dateA = strtotime($a['Date'] ?? '');
    $dateB = strtotime($b['Date'] ?? '');
    if ($dateA === $dateB) {
        return strcmp($a['Section'], $b['Section']);
    }
    return $dateA <=> $dateB;
});

// Display
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
foreach ($header as $col) {
    echo "<th>" . htmlspecialchars($col) . "</th>";
}
echo "</tr>";

foreach ($rows as $row) {
    echo "<tr>";
    foreach ($header as $col) {
        echo "<td>" . htmlspecialchars($row[$col]) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
