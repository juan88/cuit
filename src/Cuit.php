<?php
/**
 * Created by PhpStorm.
 * User: connor
 * Date: 12/04/18
 * Time: 22:07
 */

namespace Cuit;


class Cuit
{

    /**
     * Valid types
     * @var int[]
     */
    protected static $validTypes = [
        20, 23, 24, 25, 26, 27, 30
    ];

    protected static $multipliers = [
        5, 4, 3, 2, 7, 6, 5, 4, 3, 2
    ];

    /**
     * Holds the CUIT number
     * @var string
     */
    protected $number;

    /**
     * Cuit constructor.
     * @param $cuitNumber
     */
    public function __construct($cuitNumber)
    {
        $this->number = $this->parseNumber($cuitNumber);
    }

    /**
     * Validate that the type (prefix of the number) corresponds to the admitted values
     * @return bool
     */
    public function validateType()
    {
        return in_array(substr($this->number, 0, 2), static::$validTypes);
    }

    /**
     * Validates the correct length of the CUIT number
     * @return bool
     */
    public function validateLength()
    {
        return strlen($this->number) == 11;
    }

    /**
     * From a given number and type compute the corresponding CUIT checksum number
     * @param string $type
     * @param string $number
     * @return int
     */
    public function computeChecksum($type, $number)
    {
        $typeAndNumber = (string)$type . (string)$number;
        $val = 0;
        for($i = 0; $i < 10; $i++) {
            $val += (int)$typeAndNumber[$i] * static::$multipliers[$i];
        }
        $val = $val % 11;
        $val = 11 - $val;

        if($val == 11)
            return 0;
        if($val == 10)
            return 9;
        return $val;
    }

    /**
     * Validate the checksum
     * @return int
     */
    public function validateChecksum()
    {
        return $this->computeChecksum(substr($this->number, 0, 2), substr($this->number, 2, 8)) == $this->number[10];
    }

    /**
     * Parse CUIT number into a unique representation
     * @param string $cuitNumber
     * @return string
     */
    protected function parseNumber($cuitNumber)
    {
        return trim(strtr($cuitNumber, ['-'=>'']));
    }

    /**
     * Return whether a CUIT is valid or not
     * @return bool
     */
    public function validCuit()
    {
        return $this->validateLength() && $this->validateChecksum() &&  $this->validateType();
    }

}