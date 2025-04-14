<?php

// List of holidays with descriptions and "no-school" status

$holidays = [
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
    "2024-12-27" => ["December Break",              "no-school"],
    "2024-12-30" => ["December Break",              "no-school"],
    "2024-12-31" => ["December Break",              "no-school"],
    "2025-01-01" => ["December Break",              "no-school"],
    "2025-01-02" => ["December Break",              "no-school"],
    "2025-01-03" => ["December Break - End",        "no-school"],
    "2025-01-20" => ["Martin Luther King Day",      "no-school"],
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
    "2025-06-19" => ["Juneteenth - No School",      "no-school"]
];

// List of special school days with descriptions

$special_days = [

    "2024-08-27" => ["First Day of School"],
    "2024-09-25" => ["Half Day - PD",               "half-day"],
    "2024-10-30" => ["Half Day - PD",               "half-day"],
    "2024-11-19" => ["Half Day - PD",               "half-day"],
    "2024-11-27" => ["Half Day - Thanksgiving",     "half-day"],
    "2024-12-20" => ["Half Day - Staff Party",      "half-day"],
    "2025-01-08" => ["Half Day - PD",               "half-day"],
    "2025-03-12" => ["Half Day - PD",               "half-day"],
    "2025-04-15" => ["Half Day - PD",               "half-day"],
    "2025-05-02" => ["Half Day - Prom",             "half-day"],
    
    "2024-08-27" => ["First Day of School",         "important-dates"],
    "2024-09-19" => ["Parents Night 6,7,8",         "important-dates"],
    "2024-09-20" => ["Photo Day",                   "important-dates"],
    "2024-09-24" => ["Parents Night 9,10,11,12",    "important-dates"],
    "2024-10-10" => ["PSAT",                        "important-dates"],
    "2024-10-17" => ["MAML Math Olympiad",          "important-dates"],
    "2024-11-01" => ["Photo Retake Day",            "important-dates"],
    "2024-11-06" => ["AMC 10 A",                    "important-dates"],
    "2025-01-23" => ["AMC 8",                       "important-dates"],
    "2025-05-27" => ["Senior's Last Day",           "important-dates"],
    "2025-05-30" => ["Graduation",                  "important-dates"],
    
    "2024-10-31" => ["End of Quarter 1",            "end-of-quarter"],
    "2025-01-22" => ["End of Quarter 2",            "end-of-quarter"],
    "2025-04-02" => ["End of Quarter 3",            "end-of-quarter"],
    // "2025-06-20" => ["End of Quarter 4",            "end-of-quarter"],
    
];

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

?>
