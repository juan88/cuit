<?php

namespace Cuit\Test;
use Cuit\Cuit;
use PHPUnit\Framework\TestCase;

/**
 * Test case for the validator
 */
class CuitTest extends TestCase
{
    private static $validChecksum = [
        '20-17254359-7',
        '20172543597',
        '20-23156980-5',
        '20231569805',
        '27-05181210-2',
        '27-05101129-0',
    ];

    private static $invalidChecksum = [
        '20-17254359-8',
        '20172543592',
        '20-23156980-6',
        '20231569802',
        '27-05181210-3',
    ];

    private static $validWithoutChecksum = [
        '20-12345678-8',
        '23-12345678-8',
        '24-12345678-8',
        '25-12345678-8',
        '27-12345678-8',
        '30-12345678-8',
        '30-123456788',
        '30123456718',
    ];

    private static $invalidWithoutChecksum = [
        '28-1234568-8',
        '29-1234578-8',
        '29-12345678',
        '31-12345678-',
        '5-12345678-8',
        '5123456788',
    ];

    public function testValidateCorrectTypes()
    {
        foreach(static::$validWithoutChecksum as $tc) {
            $c = new Cuit($tc);
            $this->assertTrue($c->validateType());
        }
    }

    public function testNotDefinedTypesShouldNotValidate()
    {
        foreach(static::$invalidWithoutChecksum as $tc) {
            $c = new Cuit($tc);
            $this->assertFalse($c->validateType());
        }
    }

    public function testCuitHasAValidLength()
    {
        foreach(static::$validWithoutChecksum as $tc) {
            $c = new Cuit($tc);
            $this->assertTrue($c->validateLength());
        }
    }

    public function testInvalidlengthShouldNotValidate()
    {
        foreach(static::$invalidWithoutChecksum as $tc) {
            $c = new Cuit($tc);
            $this->assertFalse($c->validateLength());
        }
    }

    public function testValidateChecksum()
    {
        foreach(static::$validChecksum as $tc) {
            $c = new Cuit($tc);
            $this->assertTrue($c->validateChecksum());
        }
    }

    public function testInValidChecksumShouldNotValidate()
    {
        foreach(static::$invalidChecksum as $tc) {
            $c = new Cuit($tc);
            $this->assertFalse($c->validateChecksum());
        }
    }

    public function testValidateCuits()
    {
        foreach(static::$validChecksum as $tc) {
            $c = new Cuit($tc);
            $this->assertTrue($c->validCuit());
        }
    }

    public function testInvalidCuitsFails()
    {
        foreach(static::$invalidChecksum as $tc) {
            $c = new Cuit($tc);
            $this->assertFalse($c->validCuit());
        }
    }

    public function testCheckNumberRetreived()
    {
        $c = new Cuit('20-17254359-7');
        $this->assertEquals($c->getNumber(),'20172543597')
    }

    public function testCheckNumberRetreivedFormatted()
    {
        $c = new Cuit('20-17254359-7');
        $this->assertEquals($c->getNumber(true), '20-17254359-7')
    }
}