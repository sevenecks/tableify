<?php
namespace SevenEcks\Tableify;

use SevenEcks\StringUtils\StringUtils;

/**
 * This class is a utility package for manipulating strings in ways that. Specifically designed
 * for formatting terminal output and log output
 *
 * @author Brendan Butts <bbutts@stormcode.net>
 *
 */
class Tableify
{
    protected $su = null;
    protected $formatter = 'left';
    protected $seperator_padding = 1;
    protected $seperator = '|';
    protected $header_character = '-';
    protected $below_header_character = '-';

    /**
     * Construct the Tableify object, accepting a StringUtils class, 
     * if it is not passed in, the constructor injects one on it's own.
     *
     * @param object $string_utils;
     * @return void
     */
    public function __construct($string_utils = null)
    {
        if (!$string_utils) {
            $string_utils = new StringUtils();
        }
        $this->su = $string_utils;
    }

    public function left()
    {
        $this->formatter = 'left';
        return $this;
    }

    public function center()
    {
        $this->formatter = 'center';
        return $this;
    }

    public function right()
    {
        $this->formatter = 'right';
        return $this;
    }

    public function seperatorPadding(int $new_padding)
    {
        $this->seperator_padding = $new_padding;
        return $this;
    }

    public function seperator(string $new_seperator)
    {
        $this->seperator = $new_seperator;
        return $this;
    }
   
    public function headerCharacter(string $new_header_character)
    {
        $this->header_character = $new_header_character;
        return $this;
    }

    public function belowHeaderCharacter(string $new_below_header_character)
    {
        $this->below_header_character = $new_below_header_character;
        return $this;
    }

    public function make(array $data)
    {
        return $this->tableify($data, $this->formatter, $this->seperator_padding, $this->seperator, $this->header_character, $this->below_header_character);
    }

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
    {
        // empty table to start
        $table = [];
        // get the max length of each column in the table
        $field_lengths = $this->maxMultidimensionalArrayStringSize($data);
        // get the length of a row by mocking up a row
        $row_length = $this->calculateRowLength($field_lengths, $seperator_padding, $seperator);
        // get the top and bottom of the table
        $book_end = $this->su->fill($row_length, $header_character);
        // get the row that appears below the header row to seperate it from the other rows
        $below_header = $this->su->fill($row_length, $below_header_character);
        // add the top $book_end
        $table[] = $book_end;
        // loop over each 'row' in our array
        for ($i = 0; $i < count($data); $i++) {
            // line starts as just the left most seperator
            $line = $seperator . $this->su->fill($seperator_padding);
            // loop over each 'field' aka column in our row
            for ($j = 0; $j < count($data[$i]); $j++) {
                // format the fields such that they have a max length of the biggest field in this column
                // and add the additional padding, then pass this to the formatter method and append it to
                // the line and then add the seperator
                $line .= $this->su->{$formatter}($data[$i][$j], $field_lengths[$j]) . $this->su->fill($seperator_padding) . $seperator . $this->su->fill($seperator_padding);
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
        return $table;
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
}
