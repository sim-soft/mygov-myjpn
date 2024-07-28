# MyKAD Parser
A simple Malaysian's identity number (MyKAD, MyKID, MyKAS, MyPR, MyTentera) parser and validator.

## Install
```sh
composer require my-gov/myjpn
```

## Basic Usage
Use MyKAD parser to retrieve basic information from a given identity number.
```php
require 'vendor/autoload.php';

use Exception;
use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthdateException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthplaceCodeException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADCharactersException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADLengthException;
use MyGOV\MyJPN\MyKAD;

try {
    $idNo = '980524-14-2347';
    $idNo = '980524 14 2347';
    $idNo = '980524142347';

    $myKad = MyKAD::parse($idNo);

    if ($myKad->isValid()) {
        echo $myKad;                        // 980524142347
        echo $myKad->formal();              // 980524-14-2347
        echo $myKad->formal(false);         // 980524142347
        echo $myKad->getSpecialNumber();    // 2347

        // Gender information. For some early batch of identity number, the gender is unknown.
        echo $myKad->isMale() ? 'Male' : 'Female';      // Male
        echo $myKad->isFemale() ? 'Female' : 'Male';    // Male

        // Place of birth information
        echo $myKad->getBirthplaceCode();   // 14
        echo $myKad->getState();            // Wilayah Persekutuan (Kuala Lumpur)
        echo $myKad->getCountry();          // Malaysia

        // Age information
        echo $myKad->getBirthDate()->format('Y-m-d');   // 1998-05-24
        echo $myKad->getAge();              // 26
        echo $myKad->getActualAge();        // 26 years 2 months 4 days
        echo $myKad->getAgeOn(date_create('2 years ago'));      // 24
        echo $myKad->getActualAge(date_create('last year'));    // 25 years 2 months 4 days
        $myKad->isOver(12) // true. Check is over 12 years old?
        $myKad->isOver(18) // true. Check is over 18 years old?

        // Age group.
        echo $myKad->getAgeGroup(); // Adult.
        $myKad->isChildren();       // false
        $myKad->isYouth();          // false
        $myKad->isAdult();          // true
        $myKad->isOldAdult();       // false
        $myKad->isSeniorCitizen();  // false
    }
} catch (InvalidMyKADLengthException | InvalidMyKADBirthplaceCodeException | InvalidMyKADBirthdateException | InvalidMyKADCharactersException | Exception $throwable) {
    echo $throwable->getMessage();
}
```
## Turn Off the Exceptions
Set `exception` to **false** for disable `Exceptions`
```php
require 'vendor/autoload.php';

use MyGOV\MyJPN\MyKAD;

$myKad = MyKAD::parse('980524-14-2347', exception: false);

if ($myKad->isValid()) {
    echo $myKad->getBirthplaceCode();   // 14
    echo $myKad->getState();            // Wilayah Persekutuan (Kuala Lumpur)
} else {
    echo $myKad->getBirtplaceCode();   // null
    echo $myKad->getState();            // null
}
```
## Handling Centenarians
By default, MyKAD parser can handle birthdate below 100 years old only. Enable `isElderLy` to handle birthdate more than 100 years old.
```php
$myKad = MyKAD::parse('200618-14-2123')
$myKad->getBirthDate()->format('Y-m-d'); // 2020-06-18
$myKad->getAge(); // 4, assume this year is 2024.

$myKad = MyKAD::parse('200618-14-2123', isElderly: true)    // Enable is elderly.
$myKad->getBirthDate()->format('Y-m-d'); // 1920-06-18
$myKad->getAge(); // 104
```
## Change Display Language
There are 3 languages: English (en), Bahasa (ms), Chinese (zh-cn). The default language is english (en).
```php
MyKAD::parse('200618-14-2123')->getState();                    // output: Federal Territory (Kuala Lumpur)
MyKAD::parse('200618-14-2123', language: 'ms')->getState();    // output: Wilayah Persekutuan (Kuala Lumpur)
MyKAD::parse('200618-14-2123', language: 'zh-cn')->getState(); // output: 联邦直辖区 (吉隆坡)
```

## MyKAD Identity Number Generator
Generate a random identity number.
```php
$myKad = MyKAD::make();
echo $myKad->formal();  // 980524-14-2347
```
Generate an identity number for specific birthdate.
```php
$myKad = MyKAD::make(date_create_from_format('Y-m-d', '2021-10-31'));
echo $myKad;            // 211031142347
echo $myKad->formal();  // 211031-14-2347
```
Generate an identity number for specific gender.
```php
$myKad = MyKAD::make(male: true); // generate `male` identity number only
echo $myKad->formal();      // 980524-14-2345
echo $myKad->isMale();      // true
echo $myKad->isFemale();    // false

$myKad = MyKAD::make(male: false); // generate `female` identity number only
echo $myKad->formal();      // 210314-10-1348
echo $myKad->isMale();      // false
echo $myKad->isFemale();    // true
```
Generate an identity number for specific birthplace.
```php
$myKad = MyKAD::make(birthplaceCode: '10');
echo $myKad->formal();  // 980524-10-2347

$myKad = MyKAD::make(birthplaceCode: '82');
echo $myKad->formal();  // 010522-82-2588

// ensure generated identity number from Malaysia only.
$myKad = MyKAD::make(birthplaceCode: 'local');
echo $myKad->formal();    // 010522-02-2588
echo $myKad->getState();  // output: Kedah.
```

## Usage in Laravel Validation.
Simple Validator
```php
<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use MyGOV\MyJPN\MyKAD;

class MyKadValidator implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            if (!MyKAD::parse($value)->isValid()) {
                $fail('The :attribute is invalid.');
            }
        } catch (InvalidMyKADCharactersException $e) {
            $fail('Invalid characters.')
        } catch (InvalidMyKADLengthException $e) {
            $fail('Invalid length.')
        } catch (InvalidMyKADBirthplaceCodeException $e) {
            $fail('Invalid birth place code.')
        } catch (InvalidMyKADBirthdateException $e) {
            $fail('Invalid birthday.')
        }
    }
}

...

$request->validate([
    'id_no' => ['required', 'string', new MyKadValidator()],
]);
```
or, a simple custom rule.
```php
use Illuminate\Support\Facades\Validator;
use Closure;
use MyGOV\MyJPN\MyKAD;

$validator = Validator::make($request->all(), [
    'id_no' => [
        'required',
        function (string $attribute, mixed $value, Closure $fail) {
            if (!MyKAD::parse($value, exception: false)->isValid()) {
                $fail("The {$attribute} is invalid.");
            }
        },
    ],
]);
```
## License

The Simsoft MyGOV/MyJPN is licensed under the MIT License. See
the [LICENSE](LICENSE) file for details
