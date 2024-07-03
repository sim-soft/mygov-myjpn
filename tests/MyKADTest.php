<?php

namespace Tests;

use DateTime;
use DateTimeZone;
use Exception;
use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthdateException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthplaceCodeException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADCharactersException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADLengthException;
use MyGOV\MyJPN\MyKAD;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * MyKADTest
 */
class MyKADTest extends TestCase
{
    protected Datetimezone $tz;
    protected DateTime $testDate;

    /**
     * Setup.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->tz = new DateTimeZone('Asia/Kuala_Lumpur');
        $this->testDate = date_create_from_format('Y-m-d', '2024-02-01', $this->tz);
    }

    /**
     * Data provider.
     *
     * @return array[]
     */
    public static function dataProvider(): array
    {
        return [
            'Invalid characters' => ['A720413-97-5315', 'The identity number contains invalid characters.'],
            'Invalid length' => ['720413-12-51315', 'The identity number does not meet the expected length.'],
            'Invalid place code' => ['720413 97 5315', 'The identity number contains an unrecognized birthplace code.'],
            'Invalid birthdate' => ['720432-97-5315', 'The identity number contains an invalid birthdate.'],
            'Valid male' => ['850201-14-1357', null, '850201-14-1357', '1357', '14', 'male', 'MALAYSIA', '1985-02-01', 'Adult'],
            'Valid male 2' => ['000121-10-0819', null, '000121-10-0819', '0819', '10', 'male', 'MALAYSIA', '2000-01-21', 'Youth'],
            'Valid elder male' => ['550106-12-5821', null, '550106-12-5821', '5821', '12', 'male', 'MALAYSIA', '1955-01-06', 'Senior Citizen'],
            'Valid female' => ['850831 14 2468', null, '850831-14-2468', '2468', '14', 'female', 'MALAYSIA', '1985-08-31', 'Adult'],
            'Valid elder female' => ['691206-10-5330', null, '691206-10-5330', '5330', '10', 'female', 'MALAYSIA', '1969-12-06', 'Adult'],
        ];
    }

    #[DataProvider('dataProvider')]
    public function testMyKAD(
        string $identityNumber,
        ?string $exceptionMsg = null,
        ?string $formalValue = null,
        ?string $specialNumber = null,
        ?string $placeCode = null,
        ?string $gender = null,
        ?string $country = null,
        ?string $dob = null,
        ?string $ageGroup = null
    ): void
    {
        try {

            $myKad = MyKAD::parse($identityNumber);

            if ($myKad->isValid()) {

                $this->assertEquals(preg_replace('/[^0-9]/', '', $identityNumber), $myKad);
                $this->assertEquals($formalValue, $myKad->formal());
                $this->assertEquals($specialNumber, $myKad->getSpecialNumber());

                $this->assertEquals($gender, $myKad->isMale() ? 'male' : 'female');
                $this->assertEquals($gender, $myKad->isFemale() ? 'female' : 'male');

                $this->assertEquals($placeCode, $myKad->getBirthplaceCode());
                $this->assertEquals($country, strtoupper($myKad->getCountry()));



                $this->assertEquals($dob, $myKad->getBirthDate()->format('Y-m-d'));
                $this->assertEquals($myKad->getBirthDate()->diff(date_create(timezone: $this->tz))->y, $myKad->getAge());
                $this->assertEquals($myKad->getBirthDate()->diff($this->testDate)->y, $myKad->getAgeOn($this->testDate));

               /* echo $myKad->getActualAge(date_create('last year'));
                echo $myKad->getAgeOn(date_create('2 years ago'));
                echo $myKad->isOver(11) ? 'Is over 11': 'Is 11 or below';

                echo $myKad->isChildren() ? 'Is children' : 'Is not children';
                echo $myKad->isYouth() ? 'Is youth' : 'Is not youth';
                echo $myKad->isAdult() ? 'Is adult' : 'Is not adult';
                echo $myKad->isOldAdult() ? 'Is old adult' : 'Is not old adult';
                echo $myKad->isSeniorCitizen() ? 'Is senior citizen' : 'Is not senior citizen';*/

                $this->assertEquals($ageGroup, $myKad->getAgeGroup($this->testDate));

            }

        } catch (InvalidMyKADCharactersException|InvalidMyKADLengthException|InvalidMyKADBirthplaceCodeException|InvalidMyKADBirthdateException|Exception $throwable) {
            $this->assertEquals($exceptionMsg, $throwable->getMessage());
        }
    }
}
