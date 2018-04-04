# Tableify

Convert multi-dimensional PHP arrays into printable / loggable tables, with headers and everything!.

## Installation

Via Composer

```bash
composer require sevenecks/tableify
```

## Usage

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';
use SevenEcks\Tableify\Tableify;

$tableify = new Tableify();

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

echo "Table Construction using default values on class:\n";
$table_rows = $tableify->make($data);
foreach ($table_rows as $row) {
    echo $row . "\n";
}

echo "Table Construction using method chaining:\n";
$table_rows = $tableify->center()->seperatorPadding(2)->seperator('*')->headerCharacter('@')->make($data);
foreach ($table_rows as $row) {
    echo $row . "\n";
}

// manual construction
echo "Manual Table Construction using ->tableify:\n";
$table_rows = $tableify->tableify($data, 'left', 1, '|', '-', '-');
foreach ($table_rows as $row) {
    echo $row . "\n";
}
```
![Example Output](https://github.com/SevenEcks/tableify/blob/master/images/example.png "Example Output")

## Change Log
Please see [Change Log](CHANGELOG.md) for more information.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
