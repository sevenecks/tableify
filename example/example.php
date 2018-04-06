<?php
require_once __DIR__ . '/../vendor/autoload.php';
use SevenEcks\Tableify\Tableify;

$data = [
    ['Name', 'Date', 'Phone', 'Age'],
    ['Altec Lansing', '03/22/18', '617-555-0584', '30'],
    ['Fack', '03/22/18', '508-555-0584', '24'],
    ['Seven Ecks', '03/22/18', '+1-888-555-0584', '100'],
    ['CK', '03/22/18', 'N/A', '33'],
    ['Jason Jasonson', '03/22/18', '978-555-0584', '34'],
    ['Waxillium Wick', '03/22/18', '978-555-0584', '34'],
    ['Ruby Reide', '03/22/18', '978-555-0584', '34'],
    ['Rex Gold', '03/22/18', '978-555-0584', '34'],
    ['Juicy Vee', '03/22/18', '978-555-0584', '34'],
];

echo "Table Construction using default values on class and no method chaining:\n";
$table = Tableify::new($data);
$table = $table->make();
$table_data = $table->toArray();
foreach ($table_data as $row) {
    echo $row . "\n";
}

echo "Table Construction using method chaining:\n";
$table_rows = Tableify::new($data)->center()->seperatorPadding(2)->seperator('*')->headerCharacter('@')->make()->toArray();
foreach ($table_rows as $row) {
    echo $row . "\n";
}
// display the help list
foreach (Tableify::help() as $row) {
    echo $row . "\n";
}
