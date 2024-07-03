<?php

namespace MyGOV\MyJPN;

use DateTime;
use DateTimeZone;
use Exception;
use MyGOV\MyJPN\Exceptions\InvalidMyKADAgeException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthdateException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthplaceCodeException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADCharactersException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADLengthException;

/**
 * MyKAD class
 */
class MyKAD
{
    /** @var DateTime|null Date of birth. */
    protected ?DateTime $dob = null;

    /** @var PlaceOfBirth|null Place of birth. */
    protected ?PlaceOfBirth $birthplace = null;

    /** @var string|null Special generic number. */
    protected ?string $specialNumber = null;

    /** @var int|null Get age. */
    protected ?int $age = null;

    /** @var bool Determine the person is female. */
    protected bool $isFemale = false;

    /** @var int Valid length for a normal identity number. */
    protected int $validLength = 12;

    /** @var bool Determine it is a valid identity number. */
    protected bool $valid = false;

    /**
     * Constructor.
     *
     * @param string $identityNumber The identity number.
     * @param bool $isElderly Is the person looked older. Default: false.
     * @param DateTimeZone $timezone Timezone to be used. Default: Malaysia timezone.
     * @param bool $exception Turn on exception. Default: true.
     * @param string $language Language to be used. Supported: en, ms, & zh-cn. Default: 'en'.
     * @throws Exception
     */
    final public function __construct(
        protected string $identityNumber,
        protected bool $isElderly = false,
        protected DateTimeZone $timezone = new DateTimeZone('Asia/Kuala_Lumpur'),
        protected bool $exception = true,
        protected string $language = 'en',
    )
    {
        Lang::load($this->language);
        $this->sanitize();
        $this->parsing();
        $this->validate();
    }

    /**
     * Parse an identity number.
     *
     * @param string $identityNumber The identity number.
     * @param bool $isElderly Is the person looked older. Default: false.
     * @param DateTimeZone $timezone Timezone to be used. Default: Malaysia timezone.
     * @param bool $exception Turn on exception. Default: true.
     * @param string $language Language to be used. Supported: en, ms, & zh-cn. Default: en.
     * @return static
     * @throws Exception
     */
    public static function parse(
        string $identityNumber,
        bool $isElderly = false,
        DateTimeZone $timezone = new DateTimeZone('Asia/Kuala_Lumpur'),
        bool $exception = true,
        string $language = 'en'
    ): static
    {
        return new static($identityNumber, $isElderly, $timezone, $exception, $language);
    }


    /**
     * Remove unnecessary characters.
     *
     * @return void
     * @throws InvalidMyKADCharactersException
     */
    protected function sanitize(): void
    {
        if (!is_numeric(str_replace(['-', ' '], '', $this->identityNumber))) {
            $this->exception && throw new InvalidMyKADCharactersException(
                Lang::get('invalid_characters', 'exceptions', 'Invalid characters'),
                1001
            );
        }

        $this->identityNumber = preg_replace('/[^0-9]/', '', $this->identityNumber) ?? '';
    }

    /**
     * Parsing identity number.
     *
     * @return void
     * @throws InvalidMyKADLengthException|InvalidMyKADBirthplaceCodeException
     */
    protected function parsing(): void
    {
        if (strlen($this->identityNumber) !== $this->validLength) {
            $this->exception && throw new InvalidMyKADLengthException(
                Lang::get('invalid_length', 'exceptions', 'Invalid length'),
                1002
            );
        }

        $this->parseValidBirthdate();

        $this->birthplace = PlaceOfBirth::lookup(substr($this->identityNumber, 6, 2), $this->exception);
        $this->specialNumber = substr($this->identityNumber, 8, 4);
        $this->isFemale = ((int) substr($this->identityNumber, -1, 1)) % 2 == 0;
    }

    /**
     * Parse birthdate.
     *
     * @return void
     * @throws InvalidMyKADBirthdateException
     */
    protected function parseValidBirthdate(): void
    {
        $year = substr($this->identityNumber, 0, 2);
        $monthDay = substr($this->identityNumber, 2, 4);

        $today = date_create(timezone: $this->timezone);
        $thisYearPrefix = substr($today->format('Y'), 0, 2);

        $birthdate = date_create_from_format('Ymd', $thisYearPrefix . $year . $monthDay, $this->timezone);
        if($birthdate && $birthdate->format('Ymd') == $thisYearPrefix . $year . $monthDay) { // if is a valid date.
            $birthdate2 = clone $birthdate;
            $interval = date_interval_create_from_date_string("100 years");
            if ($interval) {
                date_sub($birthdate2, $interval);
            }

            // Assumption majority does not have age over 100yo (average life expectancy in Malaysia as of 2024 is approximately 76.79 years).
            // Only 2,296 centenarians recorded on year 2024.
            $this->dob = $birthdate > $today || $this->isElderly || $birthdate2->diff($birthdate)->y < 100
                ? $birthdate2
                : $birthdate;

            $this->age = $this->dob->diff($today)->y;
        }

        $this->dob === null
            && $this->exception
            && throw new InvalidMyKADBirthdateException(
            Lang::get('invalid_birthdate', 'exceptions', 'Invalid birthdate'),
                1003
                );
    }

    /**
     * Validate identity number.
     *
     * @return void
     */
    protected function validate(): void
    {
        $this->valid = $this->dob !== null && $this->birthplace?->valid();
    }

    /**
     * Whether it is a valid identity number.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * Whether the person is a male.
     *
     * @return bool
     */
    public function isMale(): bool
    {
        return !$this->isFemale;
    }

    /**
     * Whether the person is a female.
     *
     * @return bool
     */
    public function isFemale(): bool
    {
        return $this->isFemale;
    }

    /**
     * Get date of birth.
     *
     * @return DateTime|null
     */
    public function getBirthDate(): ?DateTime
    {
        return $this->dob;
    }

    /**
     * Get person age.
     *
     * @throws Exception
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * Get actual age. If specific date is provided, will determine the age on the specific date.
     *
     * @param DateTime|null $onDateTime On specific date.
     * @param string|null $template Display actual age template.
     * @return string|null
     * @throws Exception
     */
    public function getActualAge(
        ?DateTime $onDateTime = null,
        ?string $template = null
    ): ?string
    {
        if ($this->dob) {

            $onDateTime && $this->dob > $onDateTime
            && $this->exception
            && throw new Exception(Lang::get('invalid_on_date', 'exceptions', 'Invalid date'));

            $age = $this->dob->diff(
                $onDateTime ? $onDateTime->setTimezone($this->timezone) : new DateTime(timezone: $this->timezone)
            );

            return strtr($template ?? Lang::get('actual_age', default: ''), [
                '{year}' => $age->y,
                '{month}' => $age->m,
                '{day}' => $age->d,
            ]);
        }
        return null;
    }

    /**
     * Get age on a specific date.
     *
     * @param DateTime $dateTime The specific date.
     * @return int|null
     */
    public function getAgeOn(DateTime $dateTime): ?int
    {
        return $this->dob?->diff($dateTime->setTimezone($this->timezone))->y;
    }

    /**
     * Check is the person over specific age. If onDateTime is provided, will check age on the specific datetime.
     *
     * @param int $age The age to be checked.
     * @param DateTime|null $onDatetime On specific date.
     * @return bool
     */
    public function isOver(int $age, ?DateTime $onDatetime = null): bool
    {
        if ($age <= 0) {
            throw new InvalidMyKADAgeException(
                Lang::get('invalid_age_input', 'exceptions', 'Invalid age value')
            );
        }

        if ($onDatetime) {
            return $this->getAgeOn($onDatetime) >= $age;
        }

        if ($this->age) {
            return $this->age >= $age;
        }
        return false;
    }

    /**
     * Determine the person is a child.
     *
     * @param DateTime|null $onDatetime On specific date.
     * @return bool
     */
    public function isChildren(?DateTime $onDatetime = null): bool
    {
        if ($onDatetime) {
            $age = $this->getAgeOn($onDatetime);
            return $age >= 0 && $age <= 14;
        }
        return $this->age >= 0 && $this->age <= 14;
    }

    /**
     * Determine the person is a youth.
     *
     * @param DateTime|null $onDatetime On specific date.
     * @return bool
     */
    public function isYouth(?DateTime $onDatetime = null): bool
    {
        if ($onDatetime) {
            $age = $this->getAgeOn($onDatetime);
            return $age >= 15 && $age <= 24;
        }
        return $this->age >= 15 && $this->age <= 24;
    }

    /**
     * Determine the person is an adult.
     *
     * @param DateTime|null $onDatetime On specific date.
     * @return bool
     */
    public function isAdult(?DateTime $onDatetime = null): bool
    {
        if ($onDatetime) {
            $age = $this->getAgeOn($onDatetime);
            return $age >= 25 && $age <= 54;
        }
        return $this->age >= 25 && $this->age <= 54;
    }

    /**
     * Determine the person is an old adult.
     *
     * @param DateTime|null $onDatetime On specific date.
     * @return bool
     */
    public function isOldAdult(?DateTime $onDatetime = null): bool
    {
        if ($onDatetime) {
            $age = $this->getAgeOn($onDatetime);
            return $age >= 55 && $age <= 64;
        }
        return $this->age >= 55 && $this->age <= 64;
    }

    /**
     * Determine the person is a senior citizen.
     *
     * @param DateTime|null $onDatetime On specific date.
     * @throws Exception
     */
    public function isSeniorCitizen(?DateTime $onDatetime = null): bool
    {
        return $this->isOver(65, $onDatetime);
    }

    /**
     * Get age group.
     *
     * @param DateTime|null $onDateTime On specific date.
     * @return string
     * @throws Exception
     */
    public function getAgeGroup(?DateTime $onDateTime = null): string
    {
        return match(true) {
            $this->isChildren($onDateTime) => Lang::get('children', 'age_groups', 'Children'),
            $this->isYouth($onDateTime) => Lang::get('youth', 'age_groups', 'Youth'),
            $this->isAdult($onDateTime) => Lang::get('adult', 'age_groups', 'Adult'),
            $this->isOldAdult($onDateTime) => Lang::get('old_adult', 'age_groups', 'Old Adult'),
            $this->isSeniorCitizen($onDateTime) => Lang::get('senior_citizen', 'age_groups', 'Senior Citizen'),
            default => Lang::get('unknown_group', 'age_groups', 'Unknown Group'),
        };
    }

    /**
     * Get person's birthplace's code.
     *
     * @return string|null
     */
    public function getBirthplaceCode(): ?string
    {
        return $this->birthplace?->getCode();
    }

    /**
     * Get person's origin state.
     *
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->birthplace?->getState();
    }

    /**
     * Get person's origin country.
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->birthplace?->getCountry();
    }

    /**
     * Get special number.
     *
     * @return string|null
     */
    public function getSpecialNumber(): ?string
    {
        return $this->specialNumber;
    }

    /**
     * Get identity number.
     *
     * @param bool $officialFormat Display official format. Default: true.
     *
     * @return string|null
     */
    public function formal(bool $officialFormat = true): ?string
    {
        if ($this->isValid()) {
            return $officialFormat
                ? $this->getBirthDate()?->format('ymd') . '-' . $this->getBirthplaceCode() . '-' . $this->specialNumber
                : $this->identityNumber;
        }
        return null;
    }

    /**
     * Make a fake MyKad identity number.
     *
     * @param DateTime|null $birthdate Specify birthdate to be used.
     * @param bool|null $male Specify gender to be used.
     * @param string|null $birthplaceCode Specify birthplace to be used.
     * @param string $language Language to be used. Supported: en, ms, & zh-cn. Default: en.
     * @return static
     * @throws Exception
     */
    public static function make(
        ?DateTime $birthdate = null,
        ?bool $male = null,
        ?string $birthplaceCode = null,
        string $language = 'en',
    ): static
    {
        Lang::load($language);

        if ($birthdate === null) {
            $min = strtotime('May 1, 1990'); // Malaysia using High-Quality identity card since May 1, 1990.
            $max = time();
            $birthdate = (new DateTime(timezone: new DateTimezone('Asia/Kuala_Lumpur')))->setTimestamp(rand($min, $max));
        }

        if ($birthplaceCode) {
            PlaceOfBirth::lookup($birthplaceCode);
        }

        if ($birthplaceCode === null) {
            $birthplaceCode = (string) array_rand(PlaceOfBirth::getCodes());
        }

        $number = mt_rand(1, 9999);
        if ($male !== null) {
            $male
                ? $number % 2 === 0 && ++$number
                : $number % 2 !== 0 && ++$number;
        }

        return new static (
            $birthdate->format('ymd')
            . $birthplaceCode
            . str_pad((string) $number, 4, '0', STR_PAD_LEFT)
            , language: $language
        );
    }

    /**
     * Magic string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->isValid() ? $this->identityNumber : '';
    }
}
