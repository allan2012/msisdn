# msisdn
This is a basic PHP 7 package that basically enforces the standard number format of 2547 prrefix of Kenyan based mobile numbers. The clean method also checks for the validity of an MSISDN number if given as 07XX, 7XX or 2547XX formats. Prefixes are updated courtesy of https://en.wikipedia.org/wiki/Telephone_numbers_in_Kenya

## Installation

Download the package zip, extract and run 

```
composer install
```

### Alternatively run: 
```
composer require allan/msisdn
```

## Examples

### Get Channel

```php
use Msisdn\Utility;
include 'vendor/autoload.php';

var_dump(Utility::channel(254720000000)); // string(9) "SAFARICOM"
```

### Clean MSISDN

```php
use Msisdn\Utility;
include 'vendor/autoload.php';

var_dump(Utility::channel("0720000000")); // int(254720000000)
```
