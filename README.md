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
// display the help list
foreach (Tableify::help() as $row) {
    echo $row . "\n";
}
```
This code will result in the following tables being generated:
```
Table Construction using default values on class and no method chaining:
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
-------------------------------------------------------------------------------------
| Method                       | Description of Method                              |
-------------------------------------------------------------------------------------
| Tableify::new(array)         | Static method to create a new instance             |
| center()                     | Set the formatter to use the center method         |
| left()                       | Set the formatter to use the left method           |
| right()                      | set the formatter to use the right method          |
| setData(array)               | Set the data array on the object                   |
| seperatorPadding(string)     | Set the # of blank characters around the seperator |
| seperator(string)            | Set the seperator string                           |
| headerCharacter(string)      | Set the header character                           |
| belowHeaderCharacter(string) | Set the below header character string              |
| make()                       | Make the data into an array of table rows          |
| toArray()                    | Return the array of table rows                     |
| Tableify::help()             | Display this help!                                 |
-------------------------------------------------------------------------------------
```

## TableifyInterface

The TableifyInterface allows you to implement your own Tableify in whatever means you want while maintaining the same public facing interface. You can use dependency injection to insert your own if you have a dependency injection container.

## Change Log
Please see [Change Log](CHANGELOG.md) for more information.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
