<?php

namespace MyGOV\MyJPN;

/**
 * Language class.
 */
class Lang
{
    /** @var string Languages file path */
    protected static string $languagePath = 'languages';

    /** @var string[][] Language storage. */
    protected static array $storage = [];

    /**
     * Load language file.
     *
     * @param string $language Language to be loaded.
     * @return void
     */
    public static function load(string $language): void
    {
        $storage = require_once static::$languagePath . '/' . $language . '.php';
        if (is_array($storage)) {
            static::$storage = $storage;
        }
    }

    /**
     * Get translated text by key.
     *
     * @param string $key
     * @param string $group
     * @return string|null
     */
    public static function get(string $key, string $group = 'default'): ?string
    {
        return static::$storage[$group][$key] ?? null;
    }

    /**
     * Get all Place of birth codes.
     *
     * @param string $group
     * @return string[]
     */
    public static function getPBCodes(string $group = 'pb_codes'): array
    {
        return static::$storage[$group] ?? [];
    }
}
