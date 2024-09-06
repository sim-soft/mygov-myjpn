<?php

namespace MyGOV\MyJPN;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use MyGOV\MyJPN\Exceptions\ExtractMyKADException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADAgeException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthdateException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthplaceCodeException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADCharactersException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADLengthException;
use MyGOV\MyJPN\Exceptions\InvalidMyKADOnDateException;
use Throwable;

/**
 * MyKAD class
 */
class MyKAD
{
    const REGEX_ID_NUMBER = '/\b(\d{6}\s?-?\s?\d{2}\s?-?\s?\d{4})\b/';

    /** @var DateTimeImmutable|null Date of birth. */
    protected ?DateTimeImmutable $dob = null;

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
     * @throws Throwable
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
     * @param bool $extraction Perform identity number extraction from the given identity number string. default: false.
     * @return static
     * @throws Throwable
     */
    public static function parse(
        string $identityNumber,
        bool $isElderly = false,
        DateTimeZone $timezone = new DateTimeZone('Asia/Kuala_Lumpur'),
        bool $exception = true,
        string $language = 'en',
        bool   $extraction = false
    ): static
    {
        if ($extraction) {
            if (preg_match(self::REGEX_ID_NUMBER, $identityNumber, $matches)) {
                $identityNumber = $matches[0];
            }

            if (preg_last_error() !== PREG_NO_ERROR) {
                $exception && throw new ExtractMyKADException(preg_last_error_msg());
            }
        }

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
        $this->valid = strlen($this->identityNumber) === $this->validLength;

        !$this->valid && $this->exception && throw new InvalidMyKADLengthException(
                Lang::get('invalid_length', 'exceptions', 'Invalid length'),
                1002
        );

        if ($this->valid) {
            $this->parseValidBirthdate();

            $this->birthplace = PlaceOfBirth::lookup(substr($this->identityNumber, 6, 2), $this->exception);
            $this->specialNumber = substr($this->identityNumber, 8, 4);
            $this->isFemale = ((int)substr($this->identityNumber, -1, 1)) % 2 == 0;
        }
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

        $birthdate = date_create_immutable_from_format('Ymd', $thisYearPrefix . $year . $monthDay, $this->timezone);
        if($birthdate && $birthdate->format('Ymd') == $thisYearPrefix . $year . $monthDay) { // if is a valid date.
            $birthdate2 = $birthdate->modify('-100 years');

            // Assumption majority does not have age over 100yo (average life expectancy in Malaysia as of 2024 is approximately 76.79 years).
            // Only 2,296 centenarians recorded on year 2024.
            $this->dob = $birthdate > $today || $this->isElderly || $birthdate2->diff($today)->y < 100
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
     * @return DateTimeInterface|null
     */
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->dob;
    }

    /**
     * Get person age.
     *
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * Get actual age. If specific date is provided, will determine the age on the specific date.
     *
     * @param DateTime|DateTimeImmutable|null $onDateTime On specific date.
     * @param string|null $template Display actual age template.
     * @return string|null
     * @throws Throwable
     */
    public function getActualAge(
        DateTime|DateTimeImmutable|null $onDateTime = null,
        ?string $template = null
    ): ?string
    {
        if ($this->dob) {

            $onDateTime && $this->dob > $onDateTime
            && $this->exception
            && throw new InvalidMyKADOnDateException(
                Lang::get('invalid_on_date', 'exceptions', 'Invalid date')
            );

            $age = $this->dob->diff(
                $onDateTime
                    ? $onDateTime->setTimezone($this->timezone)
                    : new DateTimeImmutable(timezone: $this->timezone)
            );

            return strtr($template ?? Lang::get('actual_age'), [
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
     * @param DateTimeInterface $dateTime The specific date.
     * @return int|null
     */
    public function getAgeOn(DateTimeInterface $dateTime): ?int
    {
        return $this->dob?->diff($dateTime->setTimezone($this->timezone))->y;
    }

    /**
     * Check is the person over specific age. If onDateTime is provided, will check age on the specific datetime.
     *
     * @param int $age The age to be checked.
     * @param DateTimeInterface|null $onDatetime On specific date.
     * @return bool
     */
    public function isOver(int $age, ?DateTimeInterface $onDatetime = null): bool
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
     * @param DateTimeInterface|null $onDatetime On specific date.
     * @return bool
     */
    public function isChildren(?DateTimeInterface $onDatetime = null): bool
    {
        if ($onDatetime) {
            $age = (int)$this->getAgeOn($onDatetime);
            return $age >= 0 && $age <= 14;
        }
        return $this->age >= 0 && $this->age <= 14;
    }

    /**
     * Determine the person is a youth.
     *
     * @param DateTimeInterface|null $onDatetime On specific date.
     * @return bool
     */
    public function isYouth(?DateTimeInterface $onDatetime = null): bool
    {
        if ($onDatetime) {
            $age = (int)$this->getAgeOn($onDatetime);
            return $age >= 15 && $age <= 24;
        }
        return $this->age >= 15 && $this->age <= 24;
    }

    /**
     * Determine the person is an adult.
     *
     * @param DateTimeInterface|null $onDatetime On specific date.
     * @return bool
     */
    public function isAdult(?DateTimeInterface $onDatetime = null): bool
    {
        if ($onDatetime) {
            $age = (int)$this->getAgeOn($onDatetime);
            return $age >= 25 && $age <= 54;
        }
        return $this->age >= 25 && $this->age <= 54;
    }

    /**
     * Determine the person is an old adult.
     *
     * @param DateTimeInterface|null $onDatetime On specific date.
     * @return bool
     */
    public function isOldAdult(?DateTimeInterface $onDatetime = null): bool
    {
        if ($onDatetime) {
            $age = (int)$this->getAgeOn($onDatetime);
            return $age >= 55 && $age <= 64;
        }
        return $this->age >= 55 && $this->age <= 64;
    }

    /**
     * Determine the person is a senior citizen.
     *
     * @param DateTimeInterface|null $onDatetime On specific date.
     * @return bool
     */
    public function isSeniorCitizen(?DateTimeInterface $onDatetime = null): bool
    {
        return $this->isOver(65, $onDatetime);
    }

    /**
     * Get age group.
     *
     * @param DateTimeInterface|null $onDateTime On specific date.
     * @return string|null
     */
    public function getAgeGroup(?DateTimeInterface $onDateTime = null): ?string
    {
        return match(true) {
            !$this->valid => null,
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
     * @param DateTimeInterface|null $birthdate Specify birthdate to be used.
     * @param bool|null $male Specify gender to be used.
     * @param string|null $birthplaceCode Specify birthplace to be used.
     * @param string $language Language to be used. Supported: en, ms, & zh-cn. Default: en.
     * @return static
     * @throws Throwable
     */
    public static function make(
        ?DateTimeInterface $birthdate = null,
        ?bool $male = null,
        ?string $birthplaceCode = null,
        string $language = 'en',
    ): static
    {
        Lang::load($language);

        if ($birthdate === null) {
            $birthdate = (new DateTimeImmutable(timezone: new DateTimezone('Asia/Kuala_Lumpur')))
                ->setTimestamp(rand(strtotime('May 1, 1990'), time())); // Malaysia using High-Quality identity card since May 1, 1990.
        }

        if ($birthplaceCode === null) {
            $birthplaceCode = (string) array_rand(PlaceOfBirth::getCodes());
        } elseif ($birthplaceCode == 'local') {
            $birthplaceCode = (string)array_rand(PlaceOfBirth::getMYCodes());
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
