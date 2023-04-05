<?php
$csvData = array_map('str_getcsv', file("products_comma_separated.csv"));
$csvHeader = array_shift($csvData); //take header
$reasons = [];
//Collect all of the call reasons for count.
if (($handle = fopen("products_comma_separated.csv", "r")) !== FALSE) {
    fgetcsv($handle, 10000, ","); //Skip first row.
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $reasons[] = $data[0] . '@' . $data[1] . '@' . $data[2] . '@' . $data[3] . '@' . $data[4] . '@' . $data[5] . '@' . $data[6];
    }
    fclose($handle);
}
//Count each of the values and sort the array by the value.
$values = array_count_values($reasons);
arsort($values);
$fp = fopen('output.csv', 'w'); // open file
//Add header first.
@fputcsv($fp, $csvHeader);
//Get the elements in the array, and output as desired.
foreach (array_slice($values, 0, 6) as $reason => $count) {

    $fields = explode('@', $reason);
    $fields['count'] = $count;
    if ($count) {
        fputcsv($fp, $fields);
    }
    echo $reason . " (" . $count . " calls)\n";
}
