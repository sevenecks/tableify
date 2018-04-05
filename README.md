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

## API

```php
/**
 * Construct the Tableify object, accepting a StringUtils class, 
 * if it is not passed in, the constructor injects one on it's own.
 *
 * @param object $string_utils;
 * @return void
 */
public function __construct($string_utils = null)

/**
 * Set the formatter to be used on the ->make method to left
 *
 * @return $this
 */
public function left()

/** Set the formatter to be used on the ->make method to center
 *
 * @return $this
 */
public function center()

/**
 * Set the formatter to be used on the ->make method to right
 *
 * @return $this
 */
public function right()

/**
 * Set the seperator padding the ->make method uses
 *
 * @param int $new_padding
 */
public function seperatorPadding(int $new_padding)

/**
 * Set the seperator the make method will use
 *
 * @param string $new_seperator
 * @return $this
 */
public function seperator(string $new_seperator)

/**
 * Set the header_character that the make method will use
 *
 * @param string $new_header_character
 * @return $this
 */
public function headerCharacter(string $new_header_character)

/**
 * Set the character(s) to make up the row below the header
 *
 * @param string $new_below_header_character
 * @return $this
 */
public function belowHeaderCharacter(string $new_below_header_character)

/**
 * Use the method chained arguments (or defaults) to take the $data array
 * that was passed into the function and turn it into a tableified array
 * of rows of strings ready for pretty printing or logging
 *
 * @param array $data
 * @return array
 */
public function make(array $data)

/**
 * Take a multidimensional array and turn it into an array of lines, using the first interior array as the header.
 *
 * @param array $data
 * @param string $formatter
 * @param int $seperator_padding
 * @param string $seperator
 * @param string $header_character
 * @param string $below_header_character
 * @return array
 */
public function tableify(array $data, string $formatter = 'left', int $seperator_padding = 1, string $seperator = '|', string $header_character = '-',  string $below_header_character = '-')
```

## Change Log
Please see [Change Log](CHANGELOG.md) for more information.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
