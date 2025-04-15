<?php

$inputFile = 'data/powerSchoolExport.csv';
$outputFile = 'data.csv';
$outputRows = [];

// Updated headers
$headers = ['Block', 'Class Name', 'Teacher Name', 'Room', 'Student Name'];

if (($handle = fopen($inputFile, 'r')) !== false) {
    while (($data = fgetcsv($handle)) !== false) {
        if (count($data) < 6) continue;

        $cc_expression = $data[0];
        $className = $data[1];
        $teacherFirst = $data[2];
        $teacherLast = $data[3];
        $room = $data[4];

        $studentFirst = $data[5];
        $studentLast = $data[6];

        $studentFullName = trim($studentFirst . ' ' . $studentLast);

        $teacherFullName = trim($teacherFirst . ' ' . $teacherLast);

        $expandedBlocks = [];

        preg_match_all('/(\d)\(([^)]+)\)/', $cc_expression, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $period = $match[1];
            $letters = $match[2];

            if (strpos($letters, '-') !== false) {
                [$start, $end] = explode('-', $letters);
                for ($c = ord($start); $c <= ord($end); $c++) {
                    $expandedBlocks[] = $period . chr($c);
                }
            } else {
                foreach (str_split(str_replace(' ', '', $letters)) as $letter) {
                    $expandedBlocks[] = $period . $letter;
                }
            }
        }

        // Handle lone blocks like 2A, 3B not inside parentheses
        $remaining = preg_replace('/\d\([^)]+\)/', '', $cc_expression);
        preg_match_all('/\b\d[A-B]\b/', $remaining, $extra);
        foreach ($extra[0] as $e) {
            $expandedBlocks[] = $e;
        }

        if (empty($expandedBlocks)) {
            $expandedBlocks[] = $cc_expression;
        }

        foreach ($expandedBlocks as $block) {
            $num = intval(substr($block, 0, 1));
            $let = strtoupper(substr($block, 1, 1));

            if ($num < 1 || $num > 8 || !in_array($let, ['A', 'B'])) continue;

            $blockLetter = chr(ord('A') + $num - 1);  // 1–8 → A–H
            $blockNumber = $let === 'A' ? '1' : '2';  // A/B → 1/2
            $finalBlock = $blockLetter . $blockNumber;

            $outputRows[] = [$finalBlock, $className, $teacherFullName, $room, $studentFullName];
        }
    }

    fclose($handle);
}

// Output preview
echo "<h3>CSV Output (Preview)</h3>";
echo "<pre>";
echo implode(',', $headers) . "\n";
foreach ($outputRows as $row) {
    $block = $row[0];
    $className = str_replace(',', ' ', $row[1]);
    $teacher = $row[2];
    $room = $row[3];
    $student = $row[4];

    echo $block . ',' . $className . ',' . $teacher . ',' . $room . ',' . $student . "\n";
}
echo "</pre>";

// Write downloadable file
if (($csvOut = fopen($outputFile, 'w')) !== false) {
    fputcsv($csvOut, $headers);
    foreach ($outputRows as $row) {
        $block = $row[0];
        $className = str_replace(',', ' ', $row[1]);
        $teacher = $row[2];
        $room = $row[3];
        $student = $row[4];

        fputs($csvOut, $block . ',' . $className . ',' . $teacher . ',' . $room . ',' . $student . "\n");
    }
    fclose($csvOut);
    echo "<p><strong>Download:</strong> <a href=\"$outputFile\" download>Download $outputFile</a></p>";
} else {
    echo "<p>Error writing CSV file to disk.</p>";
}
