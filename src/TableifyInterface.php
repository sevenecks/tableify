<?php
namespace SevenEcks\Tableify;

use SevenEcks\StringUtils\StringUtils;

/**
 * This interface is a contract for creating a Tableify class that allows for the creation of
 * pretty printable / loggable tables from a multi-dimensional array of strings using method chaining!
 *
 * @author Brendan Butts <bbutts@stormcode.net>
 */
interface TableifyInterface
{
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
    public static function new(array $data, StringUtils $su = null);

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
}
