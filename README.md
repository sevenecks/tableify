# Tableify

Convert multi-dimensional PHP arrays into printable / loggable tables, with headers and everything!.

## Installation

Via Composer

```bash
composer require sevenecks/tableify
```
## Overview

Using method chaining is the best way to use this package. It makes for a simple, readable syntax. All the public methods aside from toArray() are chainable, in that they modify the instance of the Tableify object and return the object itself.

## Example Usage

```php
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
```
This code will result in the following tables being generated:
```
-----------------------------------------------------
| Name           | Date     | Phone           | Age |
-----------------------------------------------------
| Altec Lansing  | 03/22/18 | 617-555-0584    | 30  |
| Fack           | 03/22/18 | 508-555-0584    | 24  |
| Seven Ecks     | 03/22/18 | +1-888-555-0584 | 100 |
| CK             | 03/22/18 | N/A             | 33  |
| Jason Jasonson | 03/22/18 | 978-555-0584    | 34  |
| Waxillium Wick | 03/22/18 | 978-555-0584    | 34  |
| Ruby Reide     | 03/22/18 | 978-555-0584    | 34  |
| Rex Gold       | 03/22/18 | 978-555-0584    | 34  |
| Juicy Vee      | 03/22/18 | 978-555-0584    | 34  |
-----------------------------------------------------
Table Construction using method chaining:
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
*       Name       *    Date    *       Phone       *  Age  *
-------------------------------------------------------------
*  Altec Lansing   *  03/22/18  *   617-555-0584    *  30   *
*       Fack       *  03/22/18  *   508-555-0584    *  24   *
*    Seven Ecks    *  03/22/18  *  +1-888-555-0584  *  100  *
*        CK        *  03/22/18  *        N/A        *  33   *
*  Jason Jasonson  *  03/22/18  *   978-555-0584    *  34   *
*  Waxillium Wick  *  03/22/18  *   978-555-0584    *  34   *
*    Ruby Reide    *  03/22/18  *   978-555-0584    *  34   *
*     Rex Gold     *  03/22/18  *   978-555-0584    *  34   *
*    Juicy Vee     *  03/22/18  *   978-555-0584    *  34   *
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
```

## API

```php
/**
 * Construct the Tableify object, accepting a StringUtils class, 
 * if it is not passed in, the constructor injects one on it's own.
 *
 * @param object $string_utils;
 * @return void
 */
public function __construct(StringUtils $su = null);

/**
 * Static method for creating a new instance and passing in the $data,
 * it also allows dependency injection for a $string_utils class
 *
 * @param array $data
 * @param object $string_utils
 * @return $this
 */
public static function new (array $data, StringUtils $su = null);

/**
 * Set the data array on the object
 *
 * @param array $data
 * @return $this
 */
public function setData(array $data);

/**
 * Set the formatter to be used on the ->make method to left
 *
 * @return $this
 */
public function left();

/** Set the formatter to be used on the ->make method to center
 *
 * @return $this
 */
public function center();

/**
 * Set the formatter to be used on the ->make method to right
 *
 * @return $this
 */
public function right();

/**
 * Set the seperator padding the ->make method uses
 *
 * @param int $new_padding
 */
public function seperatorPadding(int $new_padding);

/**
 * Set the seperator the make method will use
 *
 * @param string $new_seperator
 * @return $this
 */
public function seperator(string $new_seperator);

/**
 * Set the header_character that the make method will use
 *
 * @param string $new_header_character
 * @return $this
 */
public function headerCharacter(string $new_header_character);

/**
 * Set the character(s) to make up the row below the header
 *
 * @param string $new_below_header_character
 * @return $this
 */
public function belowHeaderCharacter(string $new_below_header_character);

/**
 * Make a table based on the values assigned to the class via 
 * methods.
 *
 * @return $this
 */
public function make();

/**
 * Return the table data array for this instance
 *
 * @return array
 */
public function toArray();
```

## TableifyInterface

The TableifyInterface allows you to implement your own Tableify in whatever means you want while maintaining the same public facing interface. You can use dependency injection to insert your own if you have a dependency injection container.

## Change Log
Please see [Change Log](CHANGELOG.md) for more information.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
