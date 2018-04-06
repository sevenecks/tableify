<?php
namespace SevenEcks\Tableify;

use SevenEcks\StringUtils\StringUtils;

/**
 * This class allows you to create pretty printable / loggable tables from
 * a multi-dimensional array of strings using method chaining!
 *
 * @author Brendan Butts <bbutts@stormcode.net>
 */
class Tableify implements TableifyInterface
{
    // string library
    protected $su = null;
    // format function to use IE: left/right/center
    protected $formatter = 'left';
    // how much empty space padding around the seperator
    protected $seperator_padding = 1;
    // what's the seperator between columns going to be?
    protected $seperator = '|';
    // what should the header row be made out of?
    protected $header_character = '-';
    // what should the row below the header row be made of
    protected $below_header_character = '-';
    // the data for building the table
    private $data = [];
    // hold the created table data
    private $table = [];

    /**
     * Construct the Tableify object, accepting a StringUtils class,
     * if it is not passed in, the constructor injects one on it's own.
     *
     * @param object $string_utils;
     * @return void
     */
    public function __construct(StringUtils $su = null)
    {
        // this is here for people who don't use :new to instantiate the
        // class. It allows for dependency injection of $string_utils
        if (!$su) {
            $su = new StringUtils();
        }
        // set the $string_utils package on the instance
        $this->su = $su;
    }

    /**
     * Static method for creating a new instance and passing in the $data,
     * it also allows dependency injection for a $string_utils class
     *
     * @param array $data
     * @param object $string_utils
     * @return $this
     */
    public static function new(array $data, StringUtils $su = null)
    {
        // if no string utils exists, create one
        if (!$su) {
            $su = new StringUtils();
        }
        // create a new instance of this static class and provide the $string_utils
        $instance = new static($su);
        // set the $data on our new instance
        $instance->setData($data);
        // return the new instance object
        return $instance;
    }

    /**
     * Set the data array on the object
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set the formatter to be used on the ->make method to left
     *
     * @return $this
     */
    public function left()
    {
        $this->formatter = 'left';
        return $this;
    }

    /** Set the formatter to be used on the ->make method to center
     *
     * @return $this
     */
    public function center()
    {
        $this->formatter = 'center';
        return $this;
    }

    /**
     * Set the formatter to be used on the ->make method to right
     *
     * @return $this
     */
    public function right()
    {
        $this->formatter = 'right';
        return $this;
    }

    /**
     * Set the seperator padding the ->make method uses
     *
     * @param int $new_padding
     */
    public function seperatorPadding(int $new_padding)
    {
        $this->seperator_padding = $new_padding;
        return $this;
    }

    /**
     * Set the seperator the make method will use
     *
     * @param string $new_seperator
     * @return $this
     */
    public function seperator(string $new_seperator)
    {
        $this->seperator = $new_seperator;
        return $this;
    }
   
    /**
     * Set the header_character that the make method will use
     *
     * @param string $new_header_character
     * @return $this
     */
    public function headerCharacter(string $new_header_character)
    {
        $this->header_character = $new_header_character;
        return $this;
    }

    /**
     * Set the character(s) to make up the row below the header
     *
     * @param string $new_below_header_character
     * @return $this
     */
    public function belowHeaderCharacter(string $new_below_header_character)
    {
        $this->below_header_character = $new_below_header_character;
        return $this;
    }

    /**
     * Make a table based on the values assigned to the class via
     * methods.
     *
     * @return $this
     */
    public function make()
    {
        // empty table to start
        $table = [];
        // get the max length of each column in the table
        $field_lengths = $this->maxMultidimensionalArrayStringSize($this->data);
        // get the length of a row by mocking up a row
        $row_length = $this->calculateRowLength($field_lengths, $this->seperator_padding, $this->seperator);
        // get the top and bottom of the table
        $book_end = $this->su->fill($row_length, $this->header_character);
        // get the row that appears below the header row to seperate it from the other rows
        $below_header = $this->su->fill($row_length, $this->below_header_character);
        // add the top $book_end
        $table[] = $book_end;
        // loop over each 'row' in our array
        for ($i = 0; $i < count($this->data); $i++) {
            // line starts as just the left most seperator
            $line = $this->seperator . $this->su->fill($this->seperator_padding);
            // loop over each 'field' aka column in our row
            for ($j = 0; $j < count($this->data[$i]); $j++) {
                // format the fields such that they have a max length of the biggest field in this column
                // and add the additional padding, then pass this to the formatter method and append it to
                // the line and then add the seperator
                $line .= $this->su->{$this->formatter}($this->data[$i][$j], $field_lengths[$j]) . $this->su->fill($this->seperator_padding) . $this->seperator . $this->su->fill($this->seperator_padding);
            }
            // add the new line to the table
            $table[] = $line;
            // if this was the first row we will add a $below_header row to break it up
            if ($i == 0) {
                $table[] = $below_header;
            }
        }
        // add the bottom book end to the table
        $table[] = $book_end;
        // set the table data on the instance
        $this->table = $table;
        return $this;
    }

    /**
     * Return the table data array for this instance
     *
     * @return array
     */
    public function toArray()
    {
        return $this->table;
    }

    /**
     * Calculate the length of a row by taking it's field lengths, seperator padding and seperator and mocking
     * update a row to get the strlen of
     *
     * @param array $field_lengths
     * @param int $seperator_padding
     * @param string $seperator
     * @return int
     */
    protected function calculateRowLength(array $field_lengths, int $seperator_padding, string $seperator)
    {
        $sample_row = $seperator . $this->su->fill($seperator_padding);
        for ($i = 0; $i < count($field_lengths); $i++) {
            $sample_row .= $this->su->fill($field_lengths[$i]) . $this->su->fill($seperator_padding) . $seperator . $this->su->fill($seperator_padding);
        }
        $sample_row = rtrim($sample_row);
        return strlen($sample_row);
    }

    /**
     * For an array of length N and with each N having X columns find the max string length
     * for each column in the array, across dimensions such as [['aaaa','aaaaa'], ['bb','bbbbbbb']]
     * would yeild a return of [4, 7].
     *
     * @param array $data
     * @return array
     */
    protected function maxMultidimensionalArrayStringSize(array $data)
    {
        $lengths = [];
        for ($i =0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]); $j++) {
                $temp_length = strlen($data[$i][$j]);
                if (!isset($lengths[$j])) {
                    $lengths[$j] = $temp_length;
                    continue;
                } elseif ($lengths[$j] < $temp_length) {
                    $lengths[$j] = $temp_length;
                    continue;
                }
            }
        }
        return $lengths;
    }

    public static function help()
    {
        $help = [
            ['Method', 'Description of Method'],
            ['Tableify::new(array)', 'Static method to create a new instance'],
            ['center()', 'Set the formatter to use the center method'],
            ['left()', 'Set the formatter to use the left method'],
            ['right()', 'set the formatter to use the right method'],
            ['setData(array)', 'Set the data array on the object'],
            ['seperatorPadding(string)', 'Set the # of blank characters around the seperator'],
            ['seperator(string)', 'Set the seperator string'],
            ['headerCharacter(string)', 'Set the header character'],
            ['belowHeaderCharacter(string)', 'Set the below header character string'],
            ['make()', 'Make the data into an array of table rows'],
            ['toArray()', 'Return the array of table rows'],
            ['Tableify::help()', 'Display this help!'],
        ];

        return static::new($help)->make()->toArray();
    }
}
