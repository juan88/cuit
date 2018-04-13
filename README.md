# CUIT 

A CUIT/CUIL validator for PHP for use in Argentina.

[![Build Status](https://img.shields.io/travis/juan88/cuit.svg?style=flat)](https://travis-ci.org/juan88/cuit)

It checks the CUITs length, type and checksum number. Accepts both hyphenated and only-numbers CUITs.

```php
require_once __DIR__ . "vendor/autoload.php";

$cuit = new \Cuit\Cuit("20-12345678-9");

$cuit->validCuit(); //Will return true if the CUIT is valid.
```
