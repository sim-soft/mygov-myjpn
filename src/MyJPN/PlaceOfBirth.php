<?php

namespace MyGOV\MyJPN;

use MyGOV\MyJPN\Exceptions\InvalidMyKADBirthplaceCodeException;

/**
 * PlaceOfBirth class.
 */
class PlaceOfBirth
{
    /** @var bool Determine is a given birthplace's code is valid. */
    protected bool $valid = false;

    /** @var bool Determine a given birthplace's code is belong to Malaysia. */
    protected bool $isMYPlace = false;

    /** @var array|string[] birthplaces code belongs to Malaysia. */
    protected array $myPlaces = [
        '01', '21', '22', '23', '24',
        '02', '25', '26', '27',
        '03', '28', '29',
        '04', '30',
        '05', '31', '59',
        '06', '32', '33',
        '07', '34', '35',
        '08', '36', '37', '38', '39',
        '09', '40',
        '10', '41', '42', '43', '44',
        '11', '45', '46',
        '12', '47', '48', '49',
        '13', '50', '51', '52', '53',
        '14', '54', '55', '56', '57',
        '15', '58',
        '16',
        '82',
    ];

    /** @var string[] Birthplace's code repository */
    protected static array $codes = [];

    /**
     * Constructor.
     *
     * @param string $code Birthplace's code.
     * @param bool $exception Turn on exception. Default: true.
     */
    final public function __construct(protected string $code, protected bool $exception = true)
    {
        static::getCodes();

        $this->valid = array_key_exists($this->code, static::$codes);

        if (!$this->valid) {
            $this->exception && throw new InvalidMyKADBirthplaceCodeException(
                Lang::get('invalid_birthplace', 'exceptions', 'Invalid birth place code'),
                1004
            );
        }

        $this->isMYPlace = in_array($this->code, $this->myPlaces);
    }

    /**
     * Lookup birthplace's code.
     *
     * @param string $code Birthplace's code.
     * @param bool $exception Turn on exception. Default: true.
     * @return static
     */
    public static function lookup(string $code, bool $exception = true): static
    {
        return new static($code, $exception);
    }

    /**
     * Determine is the code is valid.
     *
     * @return bool
     */
    public function valid(): bool
    {
        return $this->valid;
    }

    /**
     * Get place code.
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->valid ? $this->code : null;
    }

    /**
     * Get state name.
     *
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->valid && $this->isMYPlace ? static::$codes[$this->code] : null;
    }

    /**
     * Get possible country name.
     *
     * @return string|null
     */
    public function getCountry(): null|string
    {
        if ($this->valid) {
            if ($this->isMYPlace) {
                return Lang::get('malaysia', default: 'Malaysia');
            } elseif (array_key_exists($this->code, static::$codes)) {
                return static::$codes[$this->code];
            }
        }

        return null;
    }

    /**
     * Get all codes and its place names.
     *
     * @return string[]
     */
    public static function getCodes(): array
    {
        if (static::$codes == []) {
            static::$codes = Lang::getPBCodes();
        }
        return static::$codes;
    }
}
